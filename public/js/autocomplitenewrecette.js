$(document).ready(function() {
    let ingredients = [];

    $.ajax({
        url: '/project_ethnogout/api/ingredient/getIngredient.php',
        method: 'GET',
        success: function(data) {
            ingredients = JSON.parse(data);
            $("#ingredient-1").autocomplete({
                source: function(request, response) {
                    let results = $.ui.autocomplete.filter(ingredients, request.term);
                    response(results.slice(0, 5));
                }
            });
        }
    });

    $("#addIngredient").click(function() {
        let ingredientCount = $(".ingredientGroup").length;
        let newIngredientGroup = $(".ingredientGroup").first().clone();
        let newIngredientNumber = ingredientCount + 1;

        newIngredientGroup.find("label").attr("for", "quantity-" + newIngredientNumber);
        newIngredientGroup.find("label").attr("for", "unit-" + newIngredientNumber);
        newIngredientGroup.find("label").attr("for", "ingredient-" + newIngredientNumber);
        newIngredientGroup.find("input[type='number']").attr("id", "quantity-" + newIngredientNumber).val("");
        newIngredientGroup.find("input[type='number']").attr('value' , '');
        newIngredientGroup.find("input[type='text']").attr('value' , '');
        newIngredientGroup.find("input[type='text']").attr("id", "unit-" + newIngredientNumber).val("");
        newIngredientGroup.find(".ingredient").attr("id", "ingredient-" + newIngredientNumber).val("");

        $("#ingredientContainer").append(newIngredientGroup);

        newIngredientGroup.find(".ingredient").autocomplete({
            source: function(request, response) {
                let results = $.ui.autocomplete.filter(ingredients, request.term);
                response(results.slice(0, 5));
            }
        });
    });

    $(document).on('click', '.remove', function() {
        if ($('.ingredientGroup').length > 1) {
            $(this).closest('.ingredientGroup').remove();
        }
    });
});
