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
            .'<th>Actions</th>'
            .'</tr>';
        $count = count($datas);
        foreach ($datas as $d) {
            $output .= '<tr>'
                .'<td>'.$count.'</td>'
                .'<td>'.$d['account_username'].' -- '.$d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'].'</td>'
                .'<td>'.nl2br($d['error_description']).'</td>'
                .'<td>'.$fx->dateToWords($d['error_date']).'</td>'
                .'<td>'.$d['error_time'].'</td>'
                .'<td>'
                    .'<input class="btn-red" type="button" value="Archive Error" />'
                .'</td>'
                .'</tr>';
            $count--;
        }
        $output .= '</table>'
            .'<div class="hr"></div>'
            .'<a href="'.URL_BASE.'admin/log/errors/"><input type="button" value="Refresh" /></a>'
            .'<a href="#archiveAll"><input class="btn-red" type="button" value="Archive All Errors" /></a>';
        return $output;
    }

}
