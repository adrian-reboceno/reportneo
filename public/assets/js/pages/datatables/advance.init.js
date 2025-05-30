function initializeTables() {
    new DataTable("#datatables", {
       topEnd: {
            features: {
                search: {
                    placeholder: 'Search'
                }
            }
        },
       
        columnDefs: [
        {
            orderable: false,
            render: DataTable.render.select(),
            targets: 0
        }
        ],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        order: [[1, 'asc']]
        });
     
}

document.addEventListener("DOMContentLoaded", function() {
    initializeTables();
});