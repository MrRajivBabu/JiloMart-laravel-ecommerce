
// website preloader
var loader = document.getElementById("preloader"); //catch the id
window.addEventListener("load",function() { //when website load
    loader .style .display = "none" //default display none

})

// my custom popup toaster success message

function successPopup(text) {
    let el = document.createElement('DIV');
    el.classList.add('popup');
    el.innerHTML = text;
    document.body.appendChild(el);
    setTimeout(() => {
      el.remove();
    },3000);
  }

//single product data view modal
$(document).ready(function(){
  $(document).on('click','.product_view',function(){
      var product_id = $(this).val();
      // alert(product_id);

      $.ajax({
          type: "get",
          url: "/single-product-view/"+product_id,
          success: function(response) {
            //clear first
            $('#product-view-title').text();
            $('#product_short_description').text();
            $('#single_product_stock_unavailable').html('');
            $('#single_product_stock_available').html('');
            $('#single_product_price').text();
            $('#single_product_discount').html('');
            $('#single_product_image').html('');
            $('#single_product_small_image').html('');
            $('#single_p_rate').html('');
            $('#single_p_rate_count').html('');
            $('#single_p_add_cart').html('');
            $('#single_p_add_wishlist').html('');
            // then load data
            if (response.status == true) {

              $('#product-view-title').text(response.product.title);
              $('#product_short_description').text(response.product_short_desc);
              //stock or not
              if (response.product.qty <= 0) {
                $('#single_product_stock_unavailable').html('Out Of stock');
              } else {
                $('#single_product_stock_available').html('In stock');
              }
              //price
              $('#single_product_price').text(response.product.price);
              $('#single_product_compare_price').text(response.product.compare_price);
              //discount
              if(response.product.compare_price !== response.product.price){
                $('#single_product_discount').html('<div class="product-badget">'+
                  response.discount+'% OFF</div>');
              }

              //thumbnail img
              $('#single_product_image').html('<img src="/uploads/product/thumbnail/'+response.product.image+'">');

              $('#single_product_small_image').html('<a href="/uploads/product/thumbnail/'    +response.product.image+'" class="popup-zoom">'+
              '<i class="far fa-search-plus"></i>'+
              '</a>');

              //star rating
              if (response.countProductRating > 0) {

                if(response.averegeRating >= 5){
                  $('#single_p_rate').html('<i class="fas fa-star"></i>'+
                                          '<i class="fas fa-star"></i>'+
                                          '<i class="fas fa-star"></i>'+
                                          '<i class="fas fa-star"></i>'+
                                          '<i class="fas fa-star"></i>');
                }
                if(response.averegeRating >= 4 && response.averegeRating < 5){
                  $('#single_p_rate').html('<i class="far fa-star"></i>'+
                                          '<i class="fas fa-star"></i>'+
                                          '<i class="fas fa-star"></i>'+
                                          '<i class="fas fa-star"></i>'+
                                          '<i class="fas fa-star"></i>');
                }
                if(response.averegeRating >= 3 && response.averegeRating < 4){
                  $('#single_p_rate').html('<i class="far fa-star"></i>'+
                                          '<i class="far fa-star"></i>'+
                                          '<i class="fas fa-star"></i>'+
                                          '<i class="fas fa-star"></i>'+
                                          '<i class="fas fa-star"></i>');
                }
                if(response.averegeRating >= 2 && response.averegeRating < 3){
                  $('#single_p_rate').html('<i class="far fa-star"></i>'+
                                          '<i class="far fa-star"></i>'+
                                          '<i class="far fa-star"></i>'+
                                          '<i class="fas fa-star"></i>'+
                                          '<i class="fas fa-star"></i>');
                }
                if(response.averegeRating >= 1 && response.averegeRating < 2){
                  $('#single_p_rate').html('<i class="far fa-star"></i>'+
                                          '<i class="far fa-star"></i>'+
                                          '<i class="far fa-star"></i>'+
                                          '<i class="far fa-star"></i>'+
                                          '<i class="fas fa-star"></i>');
                }

              }

              //rating count
              if (response.countProductRating > 0) {
                $('#single_p_rate_count').html('<a href="#">(<span>'+response.countProductRating+'</span> customer reviews)</a>');
              }

              //add to cart button
              $('#single_p_add_cart').html('<a href="javascript:void(0);" onclick="addToCart('+response.product.id+');" class="axil-btn btn-bg-primary">Add to Cart</a>');

              //add wishlist button
              $('#single_p_add_wishlist').html('<a href="javascript:void(0);" onclick="addToWishlist('+response.product.id+')" class="axil-btn wishlist-btn"><i class="far fa-heart"></i></a>');
            }
          }
      });
  });
});