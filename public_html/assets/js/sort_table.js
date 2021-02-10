function sort_table(n, tableName) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById(tableName);
    switching = true;
    var BREAKFREE = 0;

    /* Make a loop that will continue until
    no switching has been done: */
    while (switching) {
        BREAKFREE++; // PREVENT INFINITE LOOP ie. ALL CONTROLS IN COLUMN HAVE SAME VALUE

        // Start by saying: no switching is done:
        switching = false;
        rows = table.rows;

        if( rows.length > 3){ // 3 ROWS: Header, Footer and 1 row of DATA! NO SORT UNDER 3
            /* Loop through all table rows (except the
            first, which contains table headers): */
            // -2 because of empty row at bottom  
            for (i = 1; i < (rows.length - 2); i++) {
                // Start by saying there should be no switching:
                shouldSwitch = false;
                /* Get the two elements you want to compare,
                one from current row and one from the next: */
                //x = rows[i].getElementsByTagName("TD")[n];
                x = rows[i].cells[n].getElementsByTagName('input')[0].value;
                //y = rows[i + 1].getElementsByTagName("TD")[n];
                y = rows[i + 1].cells[n].getElementsByTagName('input')[0].value;

                /* Check if the two rows should switch place,
                based on the direction, asc or desc: */
                if (_dir == "asc") {
                    if (x.toLowerCase() > y.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else if (_dir == "desc") {
                    if (x.toLowerCase() < y.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                /* If a switch has been marked, make the switch
                and mark that a switch has been done: */
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                // Each time a switch is done, increase this count by 1:
                switchcount ++;
            }
            else
            {
                /* If no switching has been done AND the direction is "asc",
                set the direction to "desc" and run the while loop again. */
                if (switchcount == 0 && _dir == "asc") {
                    _dir = "desc";
                    switching = true;
                } else if( switchcount == 0 && _dir == "desc") {
                    _dir = "asc";
                    switching = true;
                }
            }
        }
        if(BREAKFREE > 1000)
        {
            exit;
        }
    }
}