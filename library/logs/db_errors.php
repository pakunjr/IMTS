a:40:{i:1;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"09:43:26";s:4:"user";s:43:"palmergawaban -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:463:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items_maintenance AS im
                LEFT JOIN imts_items AS it ON im.maintenance_item = it.item_id
                LEFT JOIN imts_persons AS ip ON im.maintenance_assigned_staff = ip.person_id
                WHERE im.maintenanceId = ?
                LIMIT 1


                Reason: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'im.maintenanceId' in 'where clause'";}i:2;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"15:05:52";s:4:"user";s:43:"palmergawaban -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:217:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items_type


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_items_type' doesn't exist";}i:3;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"15:05:52";s:4:"user";s:43:"palmergawaban -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:219:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items_state


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_items_state' doesn't exist";}i:4;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"16:01:45";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:790:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items AS items
            LEFT JOIN imts_ownership AS ownshp ON items.item_id = ownshp.ownership_item
            LEFT JOIN imts_items_type AS iType ON items.item_type = iType.item_type_id
            LEFT JOIN imts_items_state AS iState ON items.item_state = iState.item_state_id
            WHERE ownshp.ownership_owner = ?
                AND ownshp.ownership_owner_type = ? ORDER BY
                        items.item_component_of ASC
                        ,items.item_name ASC
                        ,items.item_serial_no ASC
                        ,items.item_model_no ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_items_type' doesn't exist";}i:5;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"16:02:38";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:790:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items AS items
            LEFT JOIN imts_ownership AS ownshp ON items.item_id = ownshp.ownership_item
            LEFT JOIN imts_items_type AS iType ON items.item_type = iType.item_type_id
            LEFT JOIN imts_items_state AS iState ON items.item_state = iState.item_state_id
            WHERE ownshp.ownership_owner = ?
                AND ownshp.ownership_owner_type = ? ORDER BY
                        items.item_component_of ASC
                        ,items.item_name ASC
                        ,items.item_serial_no ASC
                        ,items.item_model_no ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_items_type' doesn't exist";}i:6;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"16:03:15";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:966:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons AS per ON emp.employee_person = per.person_id
                LEFT JOIN imts_persons_employment_jobs AS job ON emp.employee_job = job.employee_job_id
                LEFT JOIN imts_persons_employment_status AS sta ON emp.employee_status = sta.employee_status_id
                WHERE
                    emp.employee_department = ?
                    AND (emp.employee_resignation_date > '2014-10-02'
                        OR emp.employee_resignation_date = '0000-00-00')
                ORDER BY
                    per.person_lastname ASC
                    ,per.person_firstname ASC
                    ,per.person_middlename ASC
                    ,per.person_suffix ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_persons_employment_status' doesn't exist";}i:7;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"16:03:15";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:804:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons AS per
                    ON emp.employee_person = per.person_id
                LEFT JOIN imts_persons_employment_jobs AS job
                    ON emp.employee_job = job.employee_job_id
                LEFT JOIN imts_persons_employment_status AS sta
                    ON emp.employee_status = sta.employee_status_id
                WHERE emp.employee_department = ?
                    AND (emp.employee_resignation_date != '0000-00-00'
                        AND emp.employee_resignation_date <= '2014-10-02')


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_persons_employment_status' doesn't exist";}i:8;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"16:03:20";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:790:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items AS items
            LEFT JOIN imts_ownership AS ownshp ON items.item_id = ownshp.ownership_item
            LEFT JOIN imts_items_type AS iType ON items.item_type = iType.item_type_id
            LEFT JOIN imts_items_state AS iState ON items.item_state = iState.item_state_id
            WHERE ownshp.ownership_owner = ?
                AND ownshp.ownership_owner_type = ? ORDER BY
                        items.item_component_of ASC
                        ,items.item_name ASC
                        ,items.item_serial_no ASC
                        ,items.item_model_no ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_items_type' doesn't exist";}i:9;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"16:08:32";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:790:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items AS items
            LEFT JOIN imts_ownership AS ownshp ON items.item_id = ownshp.ownership_item
            LEFT JOIN imts_items_type AS iType ON items.item_type = iType.item_type_id
            LEFT JOIN imts_items_state AS iState ON items.item_state = iState.item_state_id
            WHERE ownshp.ownership_owner = ?
                AND ownshp.ownership_owner_type = ? ORDER BY
                        items.item_component_of ASC
                        ,items.item_name ASC
                        ,items.item_serial_no ASC
                        ,items.item_model_no ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_items_type' doesn't exist";}i:10;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"16:08:49";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:790:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items AS items
            LEFT JOIN imts_ownership AS ownshp ON items.item_id = ownshp.ownership_item
            LEFT JOIN imts_items_type AS iType ON items.item_type = iType.item_type_id
            LEFT JOIN imts_items_state AS iState ON items.item_state = iState.item_state_id
            WHERE ownshp.ownership_owner = ?
                AND ownshp.ownership_owner_type = ? ORDER BY
                        items.item_component_of ASC
                        ,items.item_name ASC
                        ,items.item_serial_no ASC
                        ,items.item_model_no ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_items_type' doesn't exist";}i:11;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"16:09:16";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:790:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items AS items
            LEFT JOIN imts_ownership AS ownshp ON items.item_id = ownshp.ownership_item
            LEFT JOIN imts_items_type AS iType ON items.item_type = iType.item_type_id
            LEFT JOIN imts_items_state AS iState ON items.item_state = iState.item_state_id
            WHERE ownshp.ownership_owner = ?
                AND ownshp.ownership_owner_type = ? ORDER BY
                        items.item_component_of ASC
                        ,items.item_name ASC
                        ,items.item_serial_no ASC
                        ,items.item_model_no ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_items_type' doesn't exist";}i:12;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"16:09:31";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:790:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items AS items
            LEFT JOIN imts_ownership AS ownshp ON items.item_id = ownshp.ownership_item
            LEFT JOIN imts_items_type AS iType ON items.item_type = iType.item_type_id
            LEFT JOIN imts_items_state AS iState ON items.item_state = iState.item_state_id
            WHERE ownshp.ownership_owner = ?
                AND ownshp.ownership_owner_type = ? ORDER BY
                        items.item_component_of ASC
                        ,items.item_name ASC
                        ,items.item_serial_no ASC
                        ,items.item_model_no ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_items_type' doesn't exist";}i:13;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"16:15:09";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:790:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items AS items
            LEFT JOIN imts_ownership AS ownshp ON items.item_id = ownshp.ownership_item
            LEFT JOIN imts_items_type AS iType ON items.item_type = iType.item_type_id
            LEFT JOIN imts_items_state AS iState ON items.item_state = iState.item_state_id
            WHERE ownshp.ownership_owner = ?
                AND ownshp.ownership_owner_type = ? ORDER BY
                        items.item_component_of ASC
                        ,items.item_name ASC
                        ,items.item_serial_no ASC
                        ,items.item_model_no ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_items_type' doesn't exist";}i:14;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"16:15:18";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:966:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons AS per ON emp.employee_person = per.person_id
                LEFT JOIN imts_persons_employment_jobs AS job ON emp.employee_job = job.employee_job_id
                LEFT JOIN imts_persons_employment_status AS sta ON emp.employee_status = sta.employee_status_id
                WHERE
                    emp.employee_department = ?
                    AND (emp.employee_resignation_date > '2014-10-02'
                        OR emp.employee_resignation_date = '0000-00-00')
                ORDER BY
                    per.person_lastname ASC
                    ,per.person_firstname ASC
                    ,per.person_middlename ASC
                    ,per.person_suffix ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_persons_employment_status' doesn't exist";}i:15;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"16:15:18";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:804:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons AS per
                    ON emp.employee_person = per.person_id
                LEFT JOIN imts_persons_employment_jobs AS job
                    ON emp.employee_job = job.employee_job_id
                LEFT JOIN imts_persons_employment_status AS sta
                    ON emp.employee_status = sta.employee_status_id
                WHERE emp.employee_department = ?
                    AND (emp.employee_resignation_date != '0000-00-00'
                        AND emp.employee_resignation_date <= '2014-10-02')


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_persons_employment_status' doesn't exist";}i:16;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"16:17:40";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:966:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons AS per ON emp.employee_person = per.person_id
                LEFT JOIN imts_persons_employment_jobs AS job ON emp.employee_job = job.employee_job_id
                LEFT JOIN imts_persons_employment_status AS sta ON emp.employee_status = sta.employee_status_id
                WHERE
                    emp.employee_department = ?
                    AND (emp.employee_resignation_date > '2014-10-02'
                        OR emp.employee_resignation_date = '0000-00-00')
                ORDER BY
                    per.person_lastname ASC
                    ,per.person_firstname ASC
                    ,per.person_middlename ASC
                    ,per.person_suffix ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_persons_employment_status' doesn't exist";}i:17;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"16:17:40";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:804:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons AS per
                    ON emp.employee_person = per.person_id
                LEFT JOIN imts_persons_employment_jobs AS job
                    ON emp.employee_job = job.employee_job_id
                LEFT JOIN imts_persons_employment_status AS sta
                    ON emp.employee_status = sta.employee_status_id
                WHERE emp.employee_department = ?
                    AND (emp.employee_resignation_date != '0000-00-00'
                        AND emp.employee_resignation_date <= '2014-10-02')


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_persons_employment_status' doesn't exist";}i:18;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"16:21:18";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:966:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons AS per ON emp.employee_person = per.person_id
                LEFT JOIN imts_persons_employment_jobs AS job ON emp.employee_job = job.employee_job_id
                LEFT JOIN imts_persons_employment_status AS sta ON emp.employee_status = sta.employee_status_id
                WHERE
                    emp.employee_department = ?
                    AND (emp.employee_resignation_date > '2014-10-02'
                        OR emp.employee_resignation_date = '0000-00-00')
                ORDER BY
                    per.person_lastname ASC
                    ,per.person_firstname ASC
                    ,per.person_middlename ASC
                    ,per.person_suffix ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_persons_employment_status' doesn't exist";}i:19;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"16:21:18";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:804:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons AS per
                    ON emp.employee_person = per.person_id
                LEFT JOIN imts_persons_employment_jobs AS job
                    ON emp.employee_job = job.employee_job_id
                LEFT JOIN imts_persons_employment_status AS sta
                    ON emp.employee_status = sta.employee_status_id
                WHERE emp.employee_department = ?
                    AND (emp.employee_resignation_date != '0000-00-00'
                        AND emp.employee_resignation_date <= '2014-10-02')


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_persons_employment_status' doesn't exist";}i:20;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"17:05:20";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:790:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items AS items
            LEFT JOIN imts_ownership AS ownshp ON items.item_id = ownshp.ownership_item
            LEFT JOIN imts_items_type AS iType ON items.item_type = iType.item_type_id
            LEFT JOIN imts_items_state AS iState ON items.item_state = iState.item_state_id
            WHERE ownshp.ownership_owner = ?
                AND ownshp.ownership_owner_type = ? ORDER BY
                        items.item_component_of ASC
                        ,items.item_name ASC
                        ,items.item_serial_no ASC
                        ,items.item_model_no ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_items_type' doesn't exist";}i:21;a:4:{s:4:"date";s:10:"2014-10-02";s:4:"time";s:8:"17:14:55";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:790:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items AS items
            LEFT JOIN imts_ownership AS ownshp ON items.item_id = ownshp.ownership_item
            LEFT JOIN imts_items_type AS iType ON items.item_type = iType.item_type_id
            LEFT JOIN imts_items_state AS iState ON items.item_state = iState.item_state_id
            WHERE ownshp.ownership_owner = ?
                AND ownshp.ownership_owner_type = ? ORDER BY
                        items.item_component_of ASC
                        ,items.item_name ASC
                        ,items.item_serial_no ASC
                        ,items.item_model_no ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_items_type' doesn't exist";}i:22;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"08:20:40";s:4:"user";s:39:"johnphilip -- Go, John Philip Guinomma ";s:7:"details";s:1192:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items_maintenance AS im
                LEFT JOIN imts_items AS it ON im.maintenance_item = it.item_id
                LEFT JOIN imts_persons AS ip ON im.maintenance_assigned_staff = ip.person_id
                WHERE
                    ip.person_lastname LIKE ?
                    OR ip.person_firstname LIKE ?
                    OR ip.person_middlename LIKE ?
                    OR ip.person_suffix LIKE ?
                    OR it.item_name LIKE ?
                    OR it.item_serial_no LIKE ?
                    OR it.item_model_no LIKE ?
                    AND it.item_archive_state = 0
                ORDER BY
                    im.maintenance_submitted_date ASC
                    ,ip.person_lastname ASC
                    ,ip.person_middlename ASC
                    ,ip.person_firstname ASC
                    ,ip.person_suffix ASC
                    ,it.item_name ASC
                    ,it.item_serial_no ASC
                    ,it.item_model_no ASC


                Reason: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'im.maintenance_submitted_date' in 'order clause'";}i:23;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"08:28:28";s:4:"user";s:39:"johnphilip -- Go, John Philip Guinomma ";s:7:"details";s:966:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons AS per ON emp.employee_person = per.person_id
                LEFT JOIN imts_persons_employment_jobs AS job ON emp.employee_job = job.employee_job_id
                LEFT JOIN imts_persons_employment_status AS sta ON emp.employee_status = sta.employee_status_id
                WHERE
                    emp.employee_department = ?
                    AND (emp.employee_resignation_date > '2014-10-03'
                        OR emp.employee_resignation_date = '0000-00-00')
                ORDER BY
                    per.person_lastname ASC
                    ,per.person_firstname ASC
                    ,per.person_middlename ASC
                    ,per.person_suffix ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_persons_employment_status' doesn't exist";}i:24;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"08:28:28";s:4:"user";s:39:"johnphilip -- Go, John Philip Guinomma ";s:7:"details";s:804:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons AS per
                    ON emp.employee_person = per.person_id
                LEFT JOIN imts_persons_employment_jobs AS job
                    ON emp.employee_job = job.employee_job_id
                LEFT JOIN imts_persons_employment_status AS sta
                    ON emp.employee_status = sta.employee_status_id
                WHERE emp.employee_department = ?
                    AND (emp.employee_resignation_date != '0000-00-00'
                        AND emp.employee_resignation_date <= '2014-10-03')


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_persons_employment_status' doesn't exist";}i:25;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"08:30:40";s:4:"user";s:39:"johnphilip -- Go, John Philip Guinomma ";s:7:"details";s:966:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons AS per ON emp.employee_person = per.person_id
                LEFT JOIN imts_persons_employment_jobs AS job ON emp.employee_job = job.employee_job_id
                LEFT JOIN imts_persons_employment_status AS sta ON emp.employee_status = sta.employee_status_id
                WHERE
                    emp.employee_department = ?
                    AND (emp.employee_resignation_date > '2014-10-03'
                        OR emp.employee_resignation_date = '0000-00-00')
                ORDER BY
                    per.person_lastname ASC
                    ,per.person_firstname ASC
                    ,per.person_middlename ASC
                    ,per.person_suffix ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_persons_employment_status' doesn't exist";}i:26;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"08:30:40";s:4:"user";s:39:"johnphilip -- Go, John Philip Guinomma ";s:7:"details";s:804:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons AS per
                    ON emp.employee_person = per.person_id
                LEFT JOIN imts_persons_employment_jobs AS job
                    ON emp.employee_job = job.employee_job_id
                LEFT JOIN imts_persons_employment_status AS sta
                    ON emp.employee_status = sta.employee_status_id
                WHERE emp.employee_department = ?
                    AND (emp.employee_resignation_date != '0000-00-00'
                        AND emp.employee_resignation_date <= '2014-10-03')


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_persons_employment_status' doesn't exist";}i:27;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"09:14:29";s:4:"user";s:39:"johnphilip -- Go, John Philip Guinomma ";s:7:"details";s:966:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons AS per ON emp.employee_person = per.person_id
                LEFT JOIN imts_persons_employment_jobs AS job ON emp.employee_job = job.employee_job_id
                LEFT JOIN imts_persons_employment_status AS sta ON emp.employee_status = sta.employee_status_id
                WHERE
                    emp.employee_department = ?
                    AND (emp.employee_resignation_date > '2014-10-03'
                        OR emp.employee_resignation_date = '0000-00-00')
                ORDER BY
                    per.person_lastname ASC
                    ,per.person_firstname ASC
                    ,per.person_middlename ASC
                    ,per.person_suffix ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_persons_employment_status' doesn't exist";}i:28;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"09:14:29";s:4:"user";s:39:"johnphilip -- Go, John Philip Guinomma ";s:7:"details";s:804:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons AS per
                    ON emp.employee_person = per.person_id
                LEFT JOIN imts_persons_employment_jobs AS job
                    ON emp.employee_job = job.employee_job_id
                LEFT JOIN imts_persons_employment_status AS sta
                    ON emp.employee_status = sta.employee_status_id
                WHERE emp.employee_department = ?
                    AND (emp.employee_resignation_date != '0000-00-00'
                        AND emp.employee_resignation_date <= '2014-10-03')


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_persons_employment_status' doesn't exist";}i:29;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"09:36:41";s:4:"user";s:43:"palmergawaban -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:967:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items AS item
                LEFT JOIN imts_items_state AS iState ON item.item_state = iState.item_state_id
                LEFT JOIN imts_items_type AS iType ON item.item_type = iType.item_type_id
                LEFT JOIN imts_items_package AS iPackage ON item.item_package = iPackage.package_id
                WHERE (item.item_id = ?
                        OR item.item_component_of = ?)
                    AND iState.item_state_label = 'Working'
                ORDER BY
                    item.item_component_of ASC
                    ,FIELD(item.item_state, '1', '2', '3', '4')
                    ,item.item_state ASC
                    ,item.item_name ASC
                    ,item.item_serial_no ASC
                    ,item.item_model_no ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_items_state' doesn't exist";}i:30;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"09:36:51";s:4:"user";s:43:"palmergawaban -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:967:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items AS item
                LEFT JOIN imts_items_state AS iState ON item.item_state = iState.item_state_id
                LEFT JOIN imts_items_type AS iType ON item.item_type = iType.item_type_id
                LEFT JOIN imts_items_package AS iPackage ON item.item_package = iPackage.package_id
                WHERE (item.item_id = ?
                        OR item.item_component_of = ?)
                    AND iState.item_state_label = 'Working'
                ORDER BY
                    item.item_component_of ASC
                    ,FIELD(item.item_state, '1', '2', '3', '4')
                    ,item.item_state ASC
                    ,item.item_name ASC
                    ,item.item_serial_no ASC
                    ,item.item_model_no ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_items_state' doesn't exist";}i:31;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"09:38:12";s:4:"user";s:43:"palmergawaban -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:523:"Failed in executing the statement.


                SQL Query: INSERT INTO imts_items_maintenance(
                    maintenance_item
                    ,maintenance_assigned_staff
                    ,maintenance_date_submitted
                    ,maintenance_date_cleared
                    ,maintenance_status
                    ,maintenance_detailed_report
                ) VALUES(?,?,?,?,?,?)


                Reason: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'maintenance_status' in 'field list'";}i:32;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"09:47:24";s:4:"user";s:43:"palmergawaban -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:967:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items AS item
                LEFT JOIN imts_items_state AS iState ON item.item_state = iState.item_state_id
                LEFT JOIN imts_items_type AS iType ON item.item_type = iType.item_type_id
                LEFT JOIN imts_items_package AS iPackage ON item.item_package = iPackage.package_id
                WHERE (item.item_id = ?
                        OR item.item_component_of = ?)
                    AND iState.item_state_label = 'Working'
                ORDER BY
                    item.item_component_of ASC
                    ,FIELD(item.item_state, '1', '2', '3', '4')
                    ,item.item_state ASC
                    ,item.item_name ASC
                    ,item.item_serial_no ASC
                    ,item.item_model_no ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_items_state' doesn't exist";}i:33;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"09:50:26";s:4:"user";s:43:"palmergawaban -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:737:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items AS item
                LEFT JOIN imts_items_package AS iPackage ON item.item_package = iPackage.package_id
                WHERE
                    (item.item_id = ?
                        OR item.item_component_of = ?)
                    AND iState.item_state_label = 'Working'
                ORDER BY
                    item.item_component_of ASC
                    ,item.item_type ASC
                    ,item.item_name ASC
                    ,item.item_serial_no ASC
                    ,item.item_model_no ASC


                Reason: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'iState.item_state_label' in 'where clause'";}i:34;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"11:01:22";s:4:"user";s:43:"palmergawaban -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:823:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items AS items
            LEFT JOIN imts_ownership AS ownshp ON items.item_id = ownshp.ownership_item
            LEFT JOIN imts_items_type AS iType ON items.item_type = iType.item_type_id
            LEFT JOIN imts_items_state AS iState ON items.item_state = iState.item_state_id
            WHERE ownshp.ownership_owner = ?
                AND ownshp.ownership_owner_type = ? AND items.item_archive_state = 0 ORDER BY
                        items.item_component_of ASC
                        ,items.item_name ASC
                        ,items.item_serial_no ASC
                        ,items.item_model_no ASC


                Reason: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_imts.imts_items_type' doesn't exist";}i:35;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"11:21:07";s:4:"user";s:43:"palmergawaban -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:278:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items_maintenance_progress
                WHERE progress_maintenance = ?


                Reason: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'progress_maintenance' in 'where clause'";}i:36;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"11:22:10";s:4:"user";s:43:"palmergawaban -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:278:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items_maintenance_progress
                WHERE progress_maintenance = ?


                Reason: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'progress_maintenance' in 'where clause'";}i:37;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"11:22:25";s:4:"user";s:43:"palmergawaban -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:278:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items_maintenance_progress
                WHERE progress_maintenance = ?


                Reason: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'progress_maintenance' in 'where clause'";}i:38;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"11:22:47";s:4:"user";s:43:"palmergawaban -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:278:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items_maintenance_progress
                WHERE progress_maintenance = ?


                Reason: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'progress_maintenance' in 'where clause'";}i:39;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"11:23:45";s:4:"user";s:43:"palmergawaban -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:278:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items_maintenance_progress
                WHERE progress_maintenance = ?


                Reason: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'progress_maintenance' in 'where clause'";}i:40;a:4:{s:4:"date";s:10:"2014-10-03";s:4:"time";s:8:"11:28:55";s:4:"user";s:43:"palmergawaban -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:278:"Failed in executing the statement.


                SQL Query: SELECT * FROM imts_items_maintenance_progress
                WHERE progress_maintenance = ?


                Reason: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'progress_maintenance' in 'where clause'";}}