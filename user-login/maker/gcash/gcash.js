$(document).ready(function () {

    setupLeftMenu();

    $('.datatable').dataTable({
        aLengthMenu: [
            [10, 20, 40, 100, 1000, 2000, 10000, -1],
            [10, 20, 40, 100, 1000, 2000, 10000, "All"]
        ],
        iDisplayLength: -1
    });
    setSidebarHeight();

    $('a[rel*=facebox]').facebox({
        loadingImage: './../src/loading.gif',
        closeImage: './../src/closelabel.png'
    });

    $('#selectall').click(function () {  //on click
        if (this.checked) { // check select status
            $('.checkbox').each(function () { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        } else {
            $('.checkbox').each(function () { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"
            });
        }
    });

});

function date1(str) {
    new JsDatePick({
        useMode: 2,
        target: str,
        dateFormat: "%Y/%m/%d"
    });
};

function openWindow(str) {
    $("#" + str).hide();
    window.open("./../print_po.php?payment_id=" + str, 'mywindow', 'width=1020,height=600,left=150,top=20');
}

// Generate PO
function date1(str) {
    new JsDatePick({
        useMode: 2,
        target: str,
        dateFormat: "%Y/%m/%d"
    });
}

// function OnSubmitForm() {
//     if (document.myform.operation[0].checked == true) {
//         document.myform.action = "bdo_generate_pos.php";
//     } else
//         if (document.myform.operation[1].checked == true) {
//             document.myform.action = "payment_next.php";
//         }
//     return true;
// }

function OnSubmitForm() {
    if (document.myform.operation[0].checked == true) {
        document.myform.action = "gcash_mark_as_generated.php";
    }
    else if (document.myform.operation[1].checked == true) {
        document.myform.action = "gcash_generate_batch.php";
    }
    return true;
}