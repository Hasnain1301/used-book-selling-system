function getBookInfo() {
    var isbn = $("#ISBN").val();

    $.ajax({
        url: "https://www.googleapis.com/books/v1/volumes?q=isbn:" + isbn,
        dataType: "json",
        success: function(data) {
            if (data.totalItems > 0) {
                var book = data.items[0].volumeInfo;
                $("#listingTitle").val(book.title);
                $("#listingAuthor").val(book.authors ? book.authors[0] : '');
                $("textarea[name='listingDescription']").val(book.description ? book.description : '');
            } else {
                alert("Book not found please enter manually");
            }
        },
        error: function() {
            alert("Error fetching book information");
        }
    });
}
