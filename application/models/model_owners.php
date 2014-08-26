<?php

class model_owners {

    private $db;

    public function __construct () {
        $this->db = new database();
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
                    $owner = $this->db->statement(array(
                        'q'=>"SELECT * FROM imts_persons WHERE person_id = ? LIMIT 1"
                        ,'v'=>array(intval($ownerId))));
                    if (count($owner) > 0) $owner[0]['owner_type'] = 'Person';
                    break;

                case 'Department':
                    $owner = $this->db->statement(array(
                        'q'=>"SELECT * FROM imts_departments WHERE department_id = ? LIMIT 1"
                        ,'v'=>array(intval($ownerId))));
                    if (count($owner) > 0) $owner[0]['owner_type'] = 'Department';
                    break;

                default:
                    return null;
            }
            return count($owner) > 0 ? $owner[0] : null;
        } else return null;
    }



    public function readOwners () {
        $owners = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_ownership"));
        return count($owners) > 0 ? $owners : null;
    }



    public function readOwnerships ($ownershipId) {
        $ownerships = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_ownership WHERE ownership_id = ? LIMIT 1"
            ,'v'=>array(intval($ownershipId))));
        if (count($ownerships)) {
            $ownerType = $ownerships[0]['ownership_owner_type'];
            $ownerId = $ownerships[0]['ownership_owner'];

            $owner = $this->db->statement(array(
                'q'=>"SELECT * FROM imts_ownership WHERE ownership_owner = ? AND ownership_owner_type = ? ORDER BY ownership_date_released DESC"
                ,'v'=>array(intval($ownerId), $ownerType)));
            return count($owner) > 0 ? $owner : null;
        } else return null;
    }



    public function readOwnedItems ($ownerType, $ownerId) {
        $ownerships = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_ownership AS ownshp 
                LEFT JOIN imts_items AS items
                    ON ownshp.ownership_item = items.item_id
                WHERE
                    ownership_owner = ?
                    AND ownership_owner_type = ?
                ORDER BY
                    FIELD(ownership_date_released, '0000-00-00') DESC
                    ,ownership_date_released DESC"
            ,'v'=>array(intval($ownerId), $ownerType)));
        return count($ownerships) > 0 ? $ownerships : null;
    }



    public function searchOwners ($ownerType='Person', $keyword) {
        switch ($ownerType) {
            case 'Person':
                $results = $this->db->statement(array(
                    'q'=>"SELECT * FROM imts_persons
                        WHERE
                            person_firstname LIKE ?
                            OR person_middlename LIKE ?
                            OR person_lastname LIKE ?
                            OR person_birthdate LIKE ?"
                    ,'v'=>array(
                        "%$keyword%"
                        ,"%$keyword%"
                        ,"%$keyword%"
                        ,"%$keyword%")));
                break;

            case 'Department':
                $results = $this->db->statement(array(
                    'q'=>"SELECT * FROM imts_departments
                        WHERE
                            department_name LIKE ?
                            OR department_name_short LIKE ?"
                    ,'v'=>array(
                        "%$keyword%"
                        ,"%$keyword%")));
                break;

            default:
                $results = null;
        }

        return count($results) > 0 ? $results : null;
    }
    
}
