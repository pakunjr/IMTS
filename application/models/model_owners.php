<?php

class model_owners {

    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function __destruct () {

    }



    public function readOwner ($ownershipId) {
        $ownership = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_ownership WHERE ownership_id = ? LIMIT 1"
            ,'v'=>array(intval($ownershipId))));

        if (count($ownership) > 0) {
            $ownerType = $ownership[0]['ownership_owner_type'];
            $ownerId = $ownership[0]['ownership_owner'];
            switch ($ownerType) {
                case 'Person':
                    $query = "SELECT * FROM imts_persons
                        WHERE person_id = ?
                        LIMIT 1";

                    $values = array(
                        intval($ownerId));

                    $owner = $this->db->statement(array(
                        'q' => $query, 'v' => $values));

                    if (count($owner) > 0)
                        $owner[0]['owner_type'] = 'Person';
                    break;

                case 'Department':
                    $query = "SELECT * FROM imts_departments
                        WHERE department_id = ?
                        LIMIT 1";

                    $values = array(
                        intval($ownerId));

                    $owner = $this->db->statement(array(
                        'q' => $query, 'v' => $values));
                    
                    if (count($owner) > 0)
                        $owner[0]['owner_type'] = 'Department';
                    break;

                default:
                    return null;
            }
            return count($owner) > 0 ? $owner[0] : null;
        } else
            return null;
    }



    public function readOwners () {
        $query = "SELECT * FROM imts_ownership";
        $owners = $this->db->statement(array(
            'q' => $query));
        return count($owners) > 0 ? $owners : null;
    }



    public function readOwnerships ($ownershipId) {
        $ownerships = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_ownership WHERE ownership_id = ? LIMIT 1"
            ,'v'=>array(intval($ownershipId))));
        if (count($ownerships)) {
            $ownerType = $ownerships[0]['ownership_owner_type'];
            $ownerId = $ownerships[0]['ownership_owner'];

            $query = "SELECT * FROM imts_ownership
                WHERE
                    ownership_owner = ?
                    AND ownership_owner_type = ?
                ORDER BY ownership_date_released DESC";

            $values = array(
                intval($ownerId)
                ,$ownerType);

            $owner = $this->db->statement(array(
                'q' => $query, 'v' => $values));
            return count($owner) > 0 ? $owner : null;
        } else
            return null;
    }



    public function readOwnedItems ($ownerType, $ownerId) {
        $accessLevel = isset($_SESSION['user'])
            ? $_SESSION['user']['accessLevel']
            : null;

        $fx = new myFunctions();

        $includeArchiveItems = !$fx->isAccessible('Supervisor')
            ? "AND items.item_archive_state = 0"
            : '';

        $query = "SELECT * FROM imts_items AS items
            LEFT JOIN imts_ownership AS ownshp
                ON items.item_id = ownshp.ownership_item
            WHERE
                ownshp.ownership_owner = ?
                AND ownshp.ownership_owner_type = ?
                $includeArchiveItems
            ORDER BY
                items.item_component_of ASC
                ,items.item_name ASC
                ,items.item_serial_no ASC
                ,items.item_model_no ASC";

        $values = array(
            intval($ownerId)
            ,$ownerType);

        $ownerships = $this->db->statement(array(
            'q' => $query, 'v' => $values));

        return count($ownerships) > 0 ? $ownerships : null;
    }



    public function searchOwners ($ownerType='Person', $keyword) {
        switch ($ownerType) {
            case 'Person':
                $query = "SELECT * FROM imts_persons
                    WHERE
                        person_firstname LIKE ?
                        OR person_middlename LIKE ?
                        OR person_lastname LIKE ?
                        OR person_birthdate LIKE ?";

                $values = array(
                    "%$keyword%"
                    ,"%$keyword%"
                    ,"%$keyword%"
                    ,"%$keyword%");

                $results = $this->db->statement(array(
                    'q' => $query, 'v' => $values));
                break;

            case 'Department':
                $query = "SELECT * FROM imts_departments
                    WHERE
                        department_name LIKE ?
                        OR department_name_short LIKE ?";

                $values = array(
                    "%$keyword%"
                    ,"%$keyword%");

                $results = $this->db->statement(array(
                    'q' => $query, 'v' => $values));
                break;

            default:
                $results = null;
        }

        return count($results) > 0 ? $results : null;
    }
    
}
