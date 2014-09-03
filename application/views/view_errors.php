<?php

class view_errors {

    public function renderLogList ($datas) {
        if ($datas == null) return 'There are no recorded errors.';

        $fx = new myFunctions();

        $output = '<table><tr>'
            .'<th>No</th>'
            .'<th>Account -- Owner</th>'
            .'<th>Description</th>'
            .'<th>Date</th>'
            .'<th>Time</th>'
            .'</tr>';
        $count = count($datas);
        foreach ($datas as $d) {
            $output .= '<tr>'
                .'<td>'.$count.'</td>'
                .'<td>'.$d['account_username'].' -- '.$d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'].'</td>'
                .'<td>'.$d['error_description'].'</td>'
                .'<td>'.$fx->dateToWords($d['error_date']).'</td>'
                .'<td>'.$d['error_time'].'</td>'
                .'</tr>';
            $count--;
        }
        $output .= '</table>';
        return $output;
    }

}
