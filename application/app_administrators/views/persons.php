<?php

class ViewPersons extends ModelPersons
{

    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {
        
    }



    protected function renderPersonEmployments ($personId)
    {
        $employments = $this->readEmployments($personId);
        if (!empty($employments) && is_array($employments)) {
            $totalCount = count($employments);
            $table = '<table class="table"><thead><tr>
            <th>#</th>
            <th>Status</th>
            <th>Department</th>
            <th>Position</th>
            </tr></thead><tbody>';
            foreach ($employments as $employment) {
                $department = $employment['department_name'].' ('.$employment['department_name_short'].')';
                $table .= '<tr>
                <td>'.$totalCount.'</td>
                <td>'.$employment['employee_status'].'</td>
                <td>'.$department.'</td>
                <td>'.$employment['employee_job_label'].'</td>
                </tr>';
                $totalCount--;
            }
            $table .= '</tbody></table>';
        } else {
            $table = 'This person do not have any employments within the organization/company.';
        }
        return $table;
    }



    protected function renderSearchedPersons ($keyword)
    {
        $persons = $this->searchEmployee($keyword);
        if (!empty($persons) && is_array($persons)) {
            $totalCount = count($persons);
            $html = '<table class="table"><thead><tr>
            <th>#</th>
            <th>Name</th>
            <th>Employment/s</th>
            </tr></thead><tbody>';
            foreach ($persons as $person) {
                $employments = $this->renderPersonEmployments($person['person_id']);

                $html .= '<tr>
                <td>
                    <input class="data-value" type="hidden" value="'.$person['person_id'].'" />'.
                    $totalCount.'
                </td>
                <td class="data-label">'.
                    $person['person_lastname'].', '.
                    $person['person_firstname'].' '.
                    $person['person_middlename'].' '.
                    $person['person_suffix'].
                '</td>
                <td>'.$employments.'</td>
                </tr>';
                $totalCount--;
            }
            $html .= '</tbody></table>';
            return $html;
        } else {
            return 'Your keyword did not match any qualified person.';
        }
    }

}
