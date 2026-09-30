$( document ).ready(function() {

  category_val = $('#category-val').val();
  if(category_val){
    $('#category-id').val(category_val);  
    getSubCategories(category_val,1);
  }

  $('#category-id').on('change', function() {
    category_id = this.value;
    getSubCategories(category_id,null);
  });

});

function getSubCategories(id,ismain){
  
  token = $('#subscribe-token').val();
  $.ajax({
      type: "post",
      url: "/categories/get-subcategory",
      data: {
        id:id,
        _token:token
      },
      dataType: 'JSON',
      success: function (res) {

        $("#sub-category-id").empty();
        $("#sub-category-id").append(`<option value="" data-display="Product Sub Category">All</option>`);
        for (var i = 0; i < res.length; i++) {
          $("#sub-category-id").append(`<option value="${res[i].id}">${res[i].name}</option>`);
        }

        if(ismain){
          $('#sub-category-id').val($('#subcategory-val').val());
        }
      },
      error: function(error) {
          showHttpErrorAlert(error);
      } 
  });
}

function getVals(){
    // Get slider values
    let parent = this.parentNode;
    let slides = parent.getElementsByTagName("input");
      let slide1 = parseFloat( slides[0].value );
      let slide2 = parseFloat( slides[1].value );
    // Neither slider will clip the other, so make sure we determine which is larger
    if( slide1 > slide2 ){ let tmp = slide2; slide2 = slide1; slide1 = tmp; }
    
    let displayElement = parent.getElementsByClassName("rangeValues")[0];
        displayElement.innerHTML = "₱ " + slide1 + " - ₱ " + slide2;
}

window.onload = function(){
    // Initialize Sliders
    let sliderSections = document.getElementsByClassName("range-slider");
    for( let x = 0; x < sliderSections.length; x++ ){
      let sliders = sliderSections[x].getElementsByTagName("input");
      for( let y = 0; y < sliders.length; y++ ){
        if( sliders[y].type ==="range" ){
          sliders[y].oninput = getVals;
          // Manually trigger event first time to display values
          sliders[y].oninput();
        }
      }
    }
}
