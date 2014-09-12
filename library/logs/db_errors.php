a:5:{i:1;a:4:{s:4:"date";s:10:"2014-09-10";s:4:"time";s:8:"11:32:23";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:400:"Failed in executing the statement.

SQL Query: INSERT INTO imts_logs_errors(
                    error_logged_account
                    ,error_description
                    ,error_date
                    ,error_time
                    ,error_archived
                ) VALUES(?,?,?,?)

Reason: SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens";}i:2;a:4:{s:4:"date";s:10:"2014-09-12";s:4:"time";s:8:"09:18:34";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:1038:"Failed in executing the statement.

SQL Query: SELECT * FROM imts_ownership AS ownshp 
                LEFT JOIN imts_items AS items
                    ON ownshp.ownership_item = items.item_id
                LEFT JOIN imts_items_type AS iType
                    ON items.item_type = iType.item_type_id
                LEFT JOIN imts_items_state = iState
                    ON items.item_state = iState.item_state_id
                WHERE
                    ownshp.ownership_owner = ?
                    AND ownshp.ownership_owner_type = ?
                ORDER BY
                    items.item_archive_state ASC
                    ,strlen(items.item_name) ASC
                    ,items.item_name ASC
                    ,items.item_serial_no ASC
                    ,items.item_model_no ASC
                    ,FIELD(ownshp.ownership_date_released, '0000-00-00') DESC
                    ,ownshp.ownership_date_released DESC

Reason: SQLSTATE[42000]: Syntax error or access violation: 1305 FUNCTION db_imts.strlen does not exist";}i:3;a:4:{s:4:"date";s:10:"2014-09-12";s:4:"time";s:8:"09:48:50";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:1262:"Failed in executing the statement.

SQL Query: SELECT *, CAST(items.item_name) AS item_name_binary FROM imts_ownership AS ownshp 
                LEFT JOIN imts_items AS items
                    ON ownshp.ownership_item = items.item_id
                LEFT JOIN imts_items_type AS iType
                    ON items.item_type = iType.item_type_id
                LEFT JOIN imts_items_state = iState
                    ON items.item_state = iState.item_state_id
                WHERE
                    ownshp.ownership_owner = ?
                    AND ownshp.ownership_owner_type = ?
                ORDER BY
                    items.item_archive_state ASC
                    ,item_name_binary ASC
                    ,items.item_name ASC
                    ,items.item_serial_no ASC
                    ,items.item_model_no ASC
                    ,FIELD(ownshp.ownership_date_released, '0000-00-00') DESC
                    ,ownshp.ownership_date_released DESC

Reason: SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') AS item_name_binary FROM imts_ownership AS ownshp 
                LEFT JOIN i' at line 1";}i:4;a:4:{s:4:"date";s:10:"2014-09-12";s:4:"time";s:8:"09:49:08";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:1269:"Failed in executing the statement.

SQL Query: SELECT *, CAST(items.item_name AS int) AS item_name_binary FROM imts_ownership AS ownshp 
                LEFT JOIN imts_items AS items
                    ON ownshp.ownership_item = items.item_id
                LEFT JOIN imts_items_type AS iType
                    ON items.item_type = iType.item_type_id
                LEFT JOIN imts_items_state = iState
                    ON items.item_state = iState.item_state_id
                WHERE
                    ownshp.ownership_owner = ?
                    AND ownshp.ownership_owner_type = ?
                ORDER BY
                    items.item_archive_state ASC
                    ,item_name_binary ASC
                    ,items.item_name ASC
                    ,items.item_serial_no ASC
                    ,items.item_model_no ASC
                    ,FIELD(ownshp.ownership_date_released, '0000-00-00') DESC
                    ,ownshp.ownership_date_released DESC

Reason: SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'int) AS item_name_binary FROM imts_ownership AS ownshp 
                LEFT JOI' at line 1";}i:5;a:4:{s:4:"date";s:10:"2014-09-12";s:4:"time";s:8:"09:49:29";s:4:"user";s:35:"admin -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:1273:"Failed in executing the statement.

SQL Query: SELECT *, CAST(items.item_name AS Integer) AS item_name_binary FROM imts_ownership AS ownshp 
                LEFT JOIN imts_items AS items
                    ON ownshp.ownership_item = items.item_id
                LEFT JOIN imts_items_type AS iType
                    ON items.item_type = iType.item_type_id
                LEFT JOIN imts_items_state = iState
                    ON items.item_state = iState.item_state_id
                WHERE
                    ownshp.ownership_owner = ?
                    AND ownshp.ownership_owner_type = ?
                ORDER BY
                    items.item_archive_state ASC
                    ,item_name_binary ASC
                    ,items.item_name ASC
                    ,items.item_serial_no ASC
                    ,items.item_model_no ASC
                    ,FIELD(ownshp.ownership_date_released, '0000-00-00') DESC
                    ,ownshp.ownership_date_released DESC

Reason: SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'Integer) AS item_name_binary FROM imts_ownership AS ownshp 
                LEFT' at line 1";}}