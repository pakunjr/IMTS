a:2:{i:1;a:4:{s:4:"date";s:10:"2014-09-17";s:4:"time";s:8:"09:29:33";s:4:"user";s:39:"johnphilip -- Go, John Philip Guinomma ";s:7:"details";s:711:"Failed in executing the statement.

SQL Query: INSERT INTO imts_items(
                    item_name
                    ,item_serial_no
                    ,item_model_no
                    ,item_type
                    ,item_state
                    ,item_description
                    ,item_quantity
                    ,item_date_of_purchase
                    ,item_package
                    ,item_cost
                    ,item_depreciation
                    ,item_has_components
                    ,item_component_of
                ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)

Reason: SQLSTATE[22007]: Invalid datetime format: 1292 Incorrect date value: '' for column 'item_date_of_purchase' at row 1";}i:2;a:4:{s:4:"date";s:10:"2014-09-18";s:4:"time";s:8:"16:08:55";s:4:"user";s:43:"palmergawaban -- Gawaban, Palmer Cacdac Jr.";s:7:"details";s:801:"Failed in executing the statement.

SQL Query: SELECT * FROM imts_ownership AS own
                LEFT JOIN imts_items AS item ON own.ownership_item = item.item_id
                LEFT JOIN imts_items_type AS iType ON item.item_type = iType.item_type_id
                LEFT JOIN imts_items_state AS iState ON item.item_state = iState.item_state_id
                WHERE ownership_owner_type = ?
                    AND ownership_owner = ?
                ORDER BY
                    item.item_component_of ASC
                    ,FIELD(iState.item_state, '1', '2', '3', '4')
                    ,item.item_name ASC
                    ,item.item_serial_no
                    ,item.item_model_no

Reason: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'iState.item_state' in 'order clause'";}}