jQuery(document).ready(function(){  
    //how much items per page to show
    var show_per_page = 10;
    //getting the amount of elements inside content div
    var number_of_items = $('#content_pagenavigation tbody tr').length;

    //calculate the number of pages we are going to have
    var number_of_pages = Math.ceil(number_of_items/show_per_page);

    //set the value of our hidden input fields
    $('#current_page').val(0);
    $('#show_per_page').val(show_per_page);
    if(number_of_items <= show_per_page){
        $('#page_navigation').css('display', 'none');
    }

    var navigation_html = '<li class="previous_link"><a  href="javascript:previous();">«</a></li>';

    var current_link = 0;
    while (number_of_pages > current_link){
        navigation_html += '<li class="page_link" longdesc="' + current_link +'"><a  href="javascript:go_to_page(' + current_link +')" >'+ (current_link + 1) +'</a></li>';
        current_link++;
    }

    navigation_html += '<li class="next_link"><a  href="javascript:next();">»</a></li>';

    $('#page_navigation').html(navigation_html);

    //add active_page class to the first page link
    $('#page_navigation .page_link:first').addClass('active');

    //hide all the elements inside content div
    $('#content_pagenavigation tbody tr').css('display', 'none');

    //and show the first n (show_per_page) elements
    $('#content_pagenavigation tbody tr').slice(0, show_per_page).css('display', 'table-row');

});   


function previous(){
    new_page = parseInt($('#current_page').val()) - 1;
    //if there is an item before the current active link run the function
    if($('.active').prev('.page_link').length==true){
        go_to_page(new_page);
    }

}

function next(){
    new_page = parseInt($('#current_page').val()) + 1;
    //if there is an item after the current active link run the function
    if($('.active').next('.page_link').length==true){
        go_to_page(new_page);
    }

}
function go_to_page(page_num){
    //get the number of items shown per page
    var show_per_page = parseInt($('#show_per_page').val());

    //get the element number where to start the slice from
    start_from = page_num * show_per_page;

    //get the element number where to end the slice
    end_on = start_from + show_per_page;

    //hide all children elements of content div, get specific items and show them
    $('#content_pagenavigation tbody tr').css('display', 'none').slice(start_from, end_on).css('display', 'table-row');

    /*get the page link that has longdesc attribute of the current page and add active_page class to it
    and remove that class from previously active page link*/
    $('.page_link[longdesc=' + page_num +']').addClass('active').siblings('.active').removeClass('active');

    //update the current page input field
    $('#current_page').val(page_num);
}



// <nav>
// <ul class="pagination">
// <li class="active"><span>1</span></li>
// <li><a href="index.php?page=pd_history&amp;p=2">2</a></li>
// <li><a href="index.php?page=pd_history&amp;p=2">Next</a></li>
// <li><a href="index.php?page=pd_history&amp;p=2">Last</a></li>
// </ul>
// </nav>