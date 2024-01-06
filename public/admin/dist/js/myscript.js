function activeAdd(name) {
    var listItems = $("#list-sidebar li");
    listItems.each(function (i, li) {
        var a = $(li).find("a");
        var listItem = $(li).find("p");
        var html = $(listItem).html().toLowerCase();
        if (html.includes(name)) {
            $(a).addClass("active");
        }
    });
}

function activeRemove(name) {
    var listItems = $("#list-sidebar li");
    listItems.each(function (i, li) {
        var a = $(li).find("a");
        var listItem = $(li).find("p");
        var html = $(listItem).html().toLowerCase();
        if (html.includes(name)) {
            $(a).removeClass("active");
        }
    });
}

function menuOpen(name) {
    var listItems = $("#list-sidebar li");
    listItems.each(function (i, li) {
        var listItem = $(li).find("p");
        var html = $(listItem).html().toLowerCase();
        if (html.includes(name)) {
            $(li).addClass("menu-open");
        }
    });
}

function swalDelete(id, name, e) {
    Swal.fire({
        title: "Are you sure?",
        text: "Akan menghapus data dengan " + name + " and id " + id,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((willDelete) => {
        if (willDelete.value === true) {
            e.submit();
        }
    });
}

function swalHapus(e) {
    swal({
        title: "Apa kamu yakin?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            e.submit();
        }
    });
}
