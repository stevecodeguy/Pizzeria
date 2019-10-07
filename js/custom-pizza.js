let ingredients = document.getElementsByClassName('wc-pao-addon-checkbox');
let cheeseSauce = document.getElementsByClassName('wc-pao-addon-select');
let container   = document.createElement('div');

container.id                = 'img-ingredient-container';
container.style['position'] = 'absolute';
container.style['left']     = 0;
container.style['top']      = 0;
container.style['z-index']  = 1;
container.style['width']    = '500px';
container.style['height']   = '500px';

document.getElementsByClassName('woocommerce-product-gallery__image')[0].appendChild(container);

let subContainer = document.createElement('div');

subContainer.id                 = 'img-ingredient-subcontainer';
subContainer.style['position']  = 'relative';
subContainer.style['width']     = '100%';
subContainer.style['height']    = '100%';

document.getElementById('img-ingredient-container').appendChild(subContainer);


function getImages(checked, index, element){
    //fetch media images from REST API
    fetch('http://pizzeria.bcitwebdeveloper.ca/wp-json/wp/v2/media?per_page=100')
        .then(response => response.json())
        .then((data) => {
            data.map((ingredient) => {
                let checkedIngredient = element.value;

                if (ingredient.slug == 'pizza-crust'){
                    if (checked){
                        if (document.getElementsByClassName('crust').length === 0) {
                            addCrust(ingredient.source_url);
                        }
                    }
                }

                //compare image slug to check box value
                if (ingredient.slug === checkedIngredient.replace(' ', '-') || 
                    ingredient.slug === checkedIngredient.slice(0, -2)) {

                    switch (ingredient.slug) {
                    case 'cheddar':
                    case 'provolone':
                    case 'mozzarella':
                    case 'mozzarella-and-cheddar-blend':
                    case 'cheese-default':
                        if (checked){
                            addCheeseOrSauce(ingredient.source_url, index);
                        } else {
                            removeIngredient(ingredient.slug);
                        }
                        break;
                    case 'organic-tomato-sauce':
                        if (checked){
                            addCheeseOrSauce(ingredient.source_url, index);
                        } else {
                            removeIngredient(ingredient.slug);
                        }
                        break;
                    default:
                        if (checked){
                            addIngredient(ingredient.source_url, index);
                        } else {
                            removeIngredient(ingredient.slug);
                        }
                    }
                }
            })
        })
        .catch(error => alert(error));
}

function removeIngredient(removedIngredient) {
    //remove ingredient images
    let ingredient = document.getElementById(removedIngredient);

    ingredient.parentNode.removeChild(ingredient);
}

function addIngredientContainer(ingredient){
    let ingredientContainer = document.createElement('div');
        
    ingredientContainer.id                  = ingredient;
    ingredientContainer.style['width']      = '100%';
    ingredientContainer.style['height']     = '100%';
    ingredientContainer.style['position']   = 'absolute';
    ingredientContainer.style['top']        = '0';
    ingredientContainer.style['left']       = '0';

    document.getElementById('img-ingredient-container').appendChild(ingredientContainer);
}

function addIngredient(addedIngredient, index) {
    if (ingredients[index].checked === true){
        //create ingredient images and place
        const START_POSITION = 75;

        addIngredientContainer(ingredients[index].value);

        for (let x = 0; x < 7; x++){
            for (let y = 0; y < 7; y++){
                let ingredientImage = document.createElement('img');

                xpos = START_POSITION * x;
                ypos = START_POSITION * y;

                ingredientImage.className           = 'ingredient';
                ingredientImage.src                 = addedIngredient;
                ingredientImage.style['position']   = 'absolute';
                ingredientImage.style['left']       = xpos + 25 + 'px';
                ingredientImage.style['top']        = ypos + 25 + 'px';
                switch (ingredients[index].value){
                    case 'parmesan-asiago':
                    case 'feta':
                        ingredientImage.style['z-index'] = 30;
                        break;
                    default:
                        ingredientImage.style['z-index']    = Math.floor(Math.random() * 20);
                }
                ingredientImage.style['transform']  = 'translate(' + Math.floor(Math.random() * 20) + 'px , ' + Math.floor(Math.random()) + 'px )';
                ingredientImage.style['transform']  = 'scale(' + (Math.random() * (1.1 - 0.9) + 0.9) + ')';
                ingredientImage.style['transform']  = 'rotate(' + (Math.random() * (0 - 360) + 360) + 'deg)';

                document.getElementById(ingredients[index].value).appendChild(ingredientImage);
            }
        }
    }
}

function addCheeseOrSauce(addedIngredient, index) {
    //create ingredient images and place
    let ingredientContainer = document.createElement('div');
    
    ingredientContainer.id                  = ingredients[index].value;
    ingredientContainer.style['width']      = '115%';
    ingredientContainer.style['height']     = '115%';
    ingredientContainer.style['position']   = 'absolute';
    ingredientContainer.style['top']        = '25px';
    ingredientContainer.style['left']       = '25px';

    document.getElementById('img-ingredient-container').appendChild(ingredientContainer);

    let ingredientImage = document.createElement('img');

    ingredientImage.className           = 'cheese';
    ingredientImage.src                 = addedIngredient;
    ingredientImage.style['position']   = 'absolute';
    ingredientImage.style['z-index']    = 100;
    ingredientImage.style['height']     = '100%';
    ingredientImage.style['width']      = '100%';
    
    document.getElementById(ingredients[index].value).appendChild(ingredientImage);
}

function addCrust(crustSrc) {
    //create ingredient images and place
    let crust = document.createElement('img');

    crust.className           = 'crust';
    crust.src                 = crustSrc;
    crust.style['position']   = 'absolute';
    crust.style['left']       = 0 + 'px';
    crust.style['top']        = 0 + 'px';
    crust.style['z-index']    = 300;

    document.getElementsByClassName('woocommerce-product-gallery__image')[0].appendChild(crust);
}

//Assign click listeners to all ingredient check boxes
for (const [checkboxArrayIndex, element] of Object.entries(ingredients)) {
    ingredients[checkboxArrayIndex].addEventListener(
        'change', 
        () => getImages(ingredients[checkboxArrayIndex].checked, checkboxArrayIndex, element)
    );
}

for (const [dropdownArrayIndex] of Object.entries(cheeseSauce)) {
    cheeseSauce[dropdownArrayIndex].addEventListener(
        'change', 
        () => getImages(true, dropdownArrayIndex, cheeseSauce[dropdownArrayIndex])
    );
}




