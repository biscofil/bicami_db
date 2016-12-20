<?php

/**
 * Description of PgDatatables
 *
 * @author filippo
 */
class Pgdatatables {

    public function run(array $aColumns, $sTable, $sIndexColumn) {
        $CI = &get_instance();

        /*
         * Paging
         */
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($_GET['iDisplayLength']) . " OFFSET " .
                    intval($_GET['iDisplayStart']);
        }

        /*
         * Ordering
         */
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
                    " . ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }

        /*
         * Filtering
         * NOTE This assumes that the field that is being searched on is a string typed field (ie. one
         * on which ILIKE can be used). Boolean fields etc will need a modification here.
         */
        $sWhere = "";
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($_GET['bSearchable_' . $i] == "true") {
                    $sWhere .= "CAST(" . $aColumns[$i] . " AS TEXT) ILIKE '%" . pg_escape_string($_GET['sSearch']) . "%' OR ";
                }
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ")";
        }

        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
            if ($_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= "CAST(" . $aColumns[$i] . " AS TEXT) ILIKE '%" . pg_escape_string($_GET['sSearch_' . $i]) . "%' ";
            }
        }

        $sQuery = "
            SELECT " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
            FROM   $sTable
            $sWhere
            $sOrder
            $sLimit
        ";

        $rResult = $CI->mypghelper->custom_query($sQuery);

        $sQuery = "
            SELECT $sIndexColumn
            FROM   $sTable
        ";

        $rResultTotal = $CI->mypghelper->custom_query($sQuery);
        $iTotal = count($rResultTotal);

        if ($sWhere != "") {
            $sQuery = "
            SELECT $sIndexColumn
            FROM   $sTable
            $sWhere
        ";
            $rResultFilterTotal = $CI->mypghelper->custom_query($sQuery);
            $iFilteredTotal = count($rResultFilterTotal);
        } else {
            $iFilteredTotal = $iTotal;
        }

        /*
         * Output
         */
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );

        //while ($aRow = pg_fetch_array($rResult, null, PGSQL_ASSOC)) {
        foreach ($rResult as $aRow) {
            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == "version") {
                    /* Special output formatting for 'version' column */
                    $row[] = ($aRow[$aColumns[$i]] == "0") ? '-' : $aRow[$aColumns[$i]];
                } else if ($aColumns[$i] != ' ') {
                    /* General output */
                    $row[] = $aRow[$aColumns[$i]];
                }
            }
            $output['aaData'][] = $row;
        }

        echo json_encode($output);
    }

}
