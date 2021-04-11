
    class BtnCellRenderer {
    init(params) {

    this.eGui = document.createElement("div");
    this.eGui.innerHTML = '<button type="button" class="edit btn btn-warning">Edit</button> ' +
    '<button type="button" id="delete" class="delete btn btn-danger">Delete</button>';

    this.eEdit = this.eGui.querySelector('.edit');
    this.eDelete = this.eGui.querySelector('.delete');

    this.eventListener = () => {
    location.href = "/stock/in/" + params.data.id + "/edit"
};
    this.eEdit.addEventListener("click", this.eventListener);

    this.deleteEventListener = () => {
    this.sweetAlert(params.data.id);
};
    this.eDelete.addEventListener("click", this.deleteEventListener);
}

    getGui() {
    return this.eGui;
}

    sweetAlert = (id) => {

    Swal.fire({
    title: 'Are you sure?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ce1212',
    cancelButtonColor: '#007580',
    confirmButtonText: 'Delete'
}).then((result) => {
    if (result.isConfirmed) {
    // $.post("/stock/in/" + id, function (data) {
    $.ajax({
    url: '/stock/in/' + id,
    type: 'post',
    data: {_method: 'delete'},
    success: function (data,) {
    Swal.fire({
    title: data.message,
    icon: "success",
    timer: 500,
    button: false,
    position: 'top-end',
    showConfirmButton: false,
}).then(function () {
    window.location = '/stock/in'
})
}
})
} else {
    Swal.fire({
    title: "Delete Canceled!",
    position: 'top-end',
    showConfirmButton: false,
    icon: "success",
    timer: 1500,
});
}
});
}
}
    const gridOptions = {
    columnDefs: [
{headerName: "Id", field: "id", sortable: true, maxWidth: 80},
{headerName: "Name", field: "name", sortable: true},
{headerName: "Date", field: "date", sortable: true},
{headerName: "Quantity", field: "quantity", sortable: true, maxWidth: 100},
{
    headerName: "Action",
    field: "id",
    minWidth: 80,
    cellRenderer: 'btnCellRenderer',
},
    ],
    defaultColDef: {
    flex: 1,
},
    rowHeight: 50,
    components: {
    btnCellRenderer: BtnCellRenderer,
}
};
    document.addEventListener('DOMContentLoaded', function () {
    const gridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(gridDiv, gridOptions);
    agGrid.simpleHttpRequest({url: $('#myGrid').data('url')}).then(data => {
    gridOptions.api.setRowData(data);
})
});
