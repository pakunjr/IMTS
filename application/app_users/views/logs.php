<?php

class ViewLogs extends ModelLogs
{

    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {
        
    }



    protected function renderHomepage ()
    {
        $core = new SystemCore();
        $databaseLogContents = $this->getDatabaseLogContents();
        $systemLogContents = $this->readLogs();

        $html = $core->renderPageTitle().'<div class="action-block">
        Logs<div class="hr-light"></div>
        <a class="button" href="'.URL_BASE.'user_settings/logs/database/">Database log ('.count($databaseLogContents).')</a><br />
        <a class="button" href="'.URL_BASE.'user_settings/logs/system/">System log ('.count($systemLogContents).')</a>
        </div>';
        return $html;
    }



    protected function renderLogContent ($type, $systemLogStatus='Displayed')
    {
        $core = new SystemCore();
        switch ($type) {
            case 'database':
                $file = DIR_LOGS.DS.'database.php';
                if (file_exists($file)) {
                    ob_start();
                    $this->displayDatabaseLogContents();
                    $clearButton = '<a class="clear-log-button button-red" href="'.URL_BASE.'user_settings/logs/clear/database/">Clear Logs</a>';
                    $contents = $core->renderPageTitle('Database Log').
                        $clearButton.'
                        <div class="hr-light"></div>'.
                        ob_get_clean().
                        '<div class="hr-light"></div>
                        '.$clearButton.
                        '<script type="text/javascript">
                            $(document).ready(function () {
                                $(".clear-log-button").click(function () {
                                    var $button = $(this),
                                        buttonUrl = $button.attr("href"),
                                        confirmMessage = "Do you really want to clean the contents of this log? The effects of this action is undoable.";
                                    if (confirm(confirmMessage)) {
                                        window.location = buttonUrl;
                                    }
                                    return false;
                                });
                            });
                        </script>';
                    return $contents;
                } else {
                    return 'Fatal Error: Your database log file is missing.';
                }
                break;

            case 'system':
            default:
                if ($systemLogStatus === 'Archived') {
                    $pageTitle = 'System Log Archive';
                } else {
                    $pageTitle = 'System Log';
                }

                $contents = $this->readLogs($systemLogStatus);
                $totalCount = count($contents);
                if (!empty($contents) && is_array($contents)) {
                    $contentTable = '<span class="typo-type-5">Total Count: '.$totalCount.'</span>
                        <div class="hr-light"></div>
                        <table class="table">
                        <thead><tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Datetime</th>
                        <th>Account</th>
                        <th>Details</th>
                        </tr></thead><tbody>';
                    foreach ($contents as $content) {
                        $datetime = $core->transformDate(
                                $content['log_datetime']
                            );

                        if (
                            empty($content['person_firstname']) &&
                            empty($content['person_middlename']) &&
                            empty($content['person_lastname']) &&
                            empty($content['person_suffix']) &&
                            empty($content['account_username'])
                        ) {
                            $accountUser = 'No user has been logged on occurence.';
                        } else {
                            $accountUser = $content['person_lastname'].', '.
                                $content['person_firstname'].' '.
                                $content['person_middlename'].' '.
                                $content['person_suffix'].'
                                ('.$content['account_username'].')';
                        }
                        
                        $contentTable .= '<tr>
                        <td>'.$totalCount.'</td>
                        <td>'.$content['log_type'].'</td>
                        <td>'.$datetime.'</td>
                        <td>'.$accountUser.'</td>
                        <td>'.nl2br($content['log_details']).'</td>
                        </tr>';

                        $totalCount--;
                    }
                    $contentTable .= '</tbody></table>';

                    if ($systemLogStatus !== 'Archived') {
                        $clearBtn = '<a class="clear-log-button button-red" href="'.URL_BASE.'user_settings/logs/clear/system/">Clear Logs</a>';
                    } else {
                        $clearBtn = '';
                    }

                    $html = $clearBtn.'
                        <div class="hr-light"></div>'.
                        $contentTable.
                        '<div class="hr-light"></div>'.
                        $clearBtn;
                } else {
                    $html = 'Your System Log is empty.';

                    if ($systemLogStatus !== 'Archived') {
                        $archivedLogs = $this->readLogs('Archived');
                        $html .= '<div class="hr-light"></div>
                        Unlike the database log, you can check the System Log Archive.<br />
                        There are currently '.count($archivedLogs).' log item in the archive.<br />
                        <a class="button" href="'.URL_BASE.'user_settings/logs/system_archives/">Click here</a> to see the archive.';
                    }
                }
                $html = $html.'<script type="text/javascript">
                    $(document).ready(function () {
                        $(".clear-log-button").click(function () {
                            var $button = $(this),
                                buttonUrl = $button.attr("href"),
                                confirmMessage = "Do you really want to clean this log? These logs will not be deleted but will be archived for later viewing and review.";
                            if (confirm(confirmMessage)) {
                                window.location = buttonUrl;
                            }
                            return false;
                        });
                    });
                    </script>';
                $html = $core->renderPageTitle($pageTitle).$html;
                return $html;
        }
    }

}
