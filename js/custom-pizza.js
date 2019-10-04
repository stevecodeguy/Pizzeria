let ingredients = document.getElementsByClassName('wc-pao-addon-checkbox');
let container   = document.createElement('div');

container.id         = 'img-ingredient-container';
container.style['position'] = 'absolute';
container.style['left']     = 0;
container.style['top']     = 0;
container.style['z-index']  = 1;
container.style['width'] = '500px';
container.style['height'] = '500px';

document.getElementsByClassName('woocommerce-product-gallery__image')[0].appendChild(container);

let subContainer = document.createElement('div');

subContainer.className         = 'img-ingredient-subcontainer';
subContainer.style['position'] = 'relative';
subContainer.style['width'] = '100%';
subContainer.style['height'] = '100%';

document.getElementById('img-ingredient-container').appendChild(subContainer);


function getImages(index, element){
    let crust = '';
    //fetch media images from REST API
    fetch('http://localhost/pizza/wp-json/wp/v2/media?per_page=100')
        .then(response => response.json())
        .then((data) => {
            data.map((ingredient) => {
                let elementIngredient = element.value;

                if (ingredient.slug == 'pizza-crust'){
                    // console.log(ingredient.source_url);
                    addCrust(ingredient.source_url);
                }

                //compare image slug to check box value
                if (ingredient.slug === elementIngredient.replace(' ', '-')){
                    addIngredient(ingredient.source_url, index);
                }
            })
        })
        .catch(error => alert(error));
}

function addIngredient(addedIngredient, index) {
    if (ingredients[index].checked === true){
        //create ingredient images and place
        const START_POSITION = 75;

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
                ingredientImage.style['z-index']    = Math.floor(Math.random() * 20);
                ingredientImage.style['transform']  = 'translate(' + Math.floor(Math.random() * 20) + 'px , ' + Math.floor(Math.random()) + 'px )';
                ingredientImage.style['transform']  = 'scale(' + (Math.random() * (1.1 - 0.9) + 0.9) + ')';
                ingredientImage.style['transform']  = 'rotate(' + (Math.random() * (0 - 360) + 360) + 'deg)';

                document.getElementsByClassName('img-ingredient-subcontainer')[0].appendChild(ingredientImage);
            }
        }
    }
}

function addCrust(crustSrc) {
    console.log(crustSrc);
    //create ingredient images and place
    let crust = document.createElement('img');

    crust.className           = 'crust';
    crust.src                 = crustSrc;
    crust.style['position']   = 'absolute';
    crust.style['left']       = 0 + 'px';
    crust.style['top']        = 0 + 'px';
    crust.style['z-index']    = 300;
    crust.style['width']      = '100%';
    crust.style['height']     = '100%';

    document.getElementsByClassName('woocommerce-product-gallery__image')[0].appendChild(crust);
}

//Assign click listeners to all ingredient check boxes
for (const [checkboxArrayIndex, element] of Object.entries(ingredients)) {
    ingredients[checkboxArrayIndex].addEventListener('click', () => getImages(checkboxArrayIndex, element));
}