let ingredients = document.getElementsByClassName('wc-pao-addon-checkbox');
let cheeseSauce = document.getElementsByClassName('wc-pao-addon-select');
let pizzaWidth  = document.getElementsByClassName('woocommerce-product-gallery__image')[0].offsetWidth;
let pizzaHeight = document.getElementsByClassName('woocommerce-product-gallery__image')[0].offsetHeight;

const INITIAL_PIZZA_WIDTH = pizzaWidth;
const INITIAL_PIZZA_HEIGHT = pizzaHeight;
const START_POSITION = Math.floor(pizzaWidth / 8);  //75 for full screen;

let container   = document.createElement('div');

container.id                = 'img-ingredient-container';
container.style['position'] = 'absolute';
container.style['left']     = 0;
container.style['top']      = 0;
container.style['z-index']  = 1;
container.style['overflow'] = 'hidden';
container.style['width']    = pizzaWidth + 'px';
container.style['height']   = pizzaWidth + 'px';

document.getElementsByClassName('woocommerce-product-gallery__image')[0].appendChild(container);

let subContainer = document.createElement('div');

subContainer.id                 = 'img-ingredient-subcontainer';
subContainer.style['position']  = 'relative';
subContainer.style['overflow']  = 'hidden';
subContainer.style['width']     = pizzaWidth + 'px';
subContainer.style['height']    = pizzaWidth + 'px';

document.getElementById('img-ingredient-container').appendChild(subContainer);


function getImages(checked, index, element){
    let countOfIngredients = 0;
    for (let i = 0; i < ingredients.length; i++){

        if (ingredients[i].checked){
            countOfIngredients++;
        }

        if (countOfIngredients > 5){
            alert('Sorry! No more than 5 toppings on a custom pizza!');
            ingredients[index].checked = false;
            return;
        }
    }

    //fetch media images from REST API
    fetch('https://pizzeria.bcitwebdeveloper.ca/wp-json/wp/v2/media?per_page=100')
        .then(response => response.json())
        .then((data) => {
            data.map((ingredient) => {
                let checkedIngredient = element.value;

                if (ingredient.slug == 'pizza-crust'){
                    // if (checked){
                        // if (document.getElementsByClassName('crust').length === 0) {
                            console.log(ingredient.source_url)
                            addCrust(ingredient.source_url);
                        // }
                    // }
                }

                //compare image slug to check box value
                if (ingredient.slug === checkedIngredient.replace(' ', '-') || 
                    ingredient.slug === checkedIngredient.slice(0, -2)) {

                    switch (ingredient.slug) {
                    case 'cheddar':
                    case 'provolone':
                    case 'mozzarella':
                    case 'mozzarella-and-cheddar-blend':
                        if (checked){
                            // addCheeseOrSauce((ingredient.source_url).slice(0, -4) + '-base.png', 'cheese', 2);
                            addCheeseOrSauce(ingredient.source_url, 'cheese', 2);
                        } else {
                            removeIngredient(ingredient.slug);
                        }
                        break;
                    case 'alfredo-sauce':
                    case 'barbeque-sauce':
                    case 'cheesy-cheddar-sauce':
                    case 'fresh-salsa':
                    case 'organic-tomato-sauce':
                        if (checked){
                            addCheeseOrSauce(ingredient.source_url, 'sauce', 1);
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
    ingredientContainer.style['width']      = pizzaWidth + 'px';
    ingredientContainer.style['height']     = pizzaWidth + 'px';
    ingredientContainer.style['position']   = 'absolute';
    ingredientContainer.style['top']        = '0';
    ingredientContainer.style['left']       = '0';

    document.getElementById('img-ingredient-container').appendChild(ingredientContainer);
}


function addIngredient(addedIngredientURL, index) {
    if (ingredients[index].checked === true){
        //create ingredient images and place
        addIngredientContainer(ingredients[index].value);

        for (let x = 0; x < 7; x++){
            for (let y = 0; y < 7; y++){
                let ingredientImage = document.createElement('img');

                xpos = START_POSITION * x;
                ypos = START_POSITION * y;

                ingredientImage.className           = 'topping ' + ingredients[index].value;
                ingredientImage.src                 = addedIngredientURL;
                ingredientImage.style['position']   = 'absolute';
                ingredientImage.style['left']       = xpos + 25 + 'px';
                ingredientImage.style['top']        = ypos + 25 + 'px';
                ingredientImage.style['height']     = (pizzaWidth / 6) + 'px';
                ingredientImage.style['width']      = (pizzaWidth / 6) + 'px';
                switch (ingredients[index].value){
                    case 'parmesan-asiago':
                    case 'feta':
                        ingredientImage.style['z-index'] = 30;
                        break;
                    default:
                        ingredientImage.style['z-index']    = Math.floor(Math.random() * (20 - 3) + 3);
                        break;
                }
                ingredientImage.style['transform']  = 'translate(' + Math.floor(Math.random() * 20) + 'px , ' + Math.floor(Math.random()) + 'px )';
                ingredientImage.style['transform']  = 'scale(' + (Math.random() * (1.1 - 0.9) + 0.9) + ')';
                ingredientImage.style['transform']  = 'rotate(' + (Math.random() * (0 - 360) + 360) + 'deg)';

                document.getElementById(ingredients[index].value).appendChild(ingredientImage);
            }
        }
        pizzaSize();
    }
}


function addCheeseOrSauce(addedSauceOrCheeseURL, cheeseOrSauce, zIndex) {
    //create ingredient images and place

    let sauceCheeseContainer = '';

    if (zIndex < 100) {
        if (document.getElementById(cheeseOrSauce)){
            removeIngredient(cheeseOrSauce);
        }

        sauceCheeseContainer = document.createElement('div');

        sauceCheeseContainer.id                  = cheeseOrSauce;
        sauceCheeseContainer.style['width']      = pizzaWidth + 'px';
        sauceCheeseContainer.style['height']     = pizzaWidth + 'px';
        sauceCheeseContainer.style['position']   = 'absolute';
        sauceCheeseContainer.style['top']        = '0';
        sauceCheeseContainer.style['left']       = '0';

        document.getElementById('img-ingredient-container').appendChild(sauceCheeseContainer);
    } else {
        sauceCheeseContainer = document.getElementById('cheese');
    }
    

    let sauceCheeseImage = document.createElement('img');
    
    sauceCheeseImage.className           = cheeseOrSauce;
    sauceCheeseImage.src                 = addedSauceOrCheeseURL;
    sauceCheeseImage.style['position']   = 'absolute';
    sauceCheeseImage.style['height']     = pizzaWidth + 'px';
    sauceCheeseImage.style['width']      = pizzaWidth + 'px';
    sauceCheeseImage.style['transform']  = 'rotate(' + (Math.random() * (0 - 360) + 360) + 'deg)';
    sauceCheeseImage.style['z-index']    = zIndex;

    document.getElementById(cheeseOrSauce).appendChild(sauceCheeseImage);

    pizzaSize();
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
    crust.style['overflow']   = 'hidden';

    document.getElementsByClassName('woocommerce-product-gallery__image')[0].appendChild(crust);
}


function pizzaSize(){
    pizzaWidth  = document.getElementsByClassName('woocommerce-product-gallery__wrapper')[0].offsetWidth;
    pizzaHeight = document.getElementsByClassName('woocommerce-product-gallery__wrapper')[0].offsetHeight;
    
    let percentAdjustWidth  =  pizzaWidth / INITIAL_PIZZA_WIDTH;
    let percentAdjustHeight =  pizzaHeight / INITIAL_PIZZA_HEIGHT;

    let topping = document.getElementsByClassName('topping');
    if (topping.length > 0){
        let xPosition = 0;
        let yPosition = 0;
        for (let i = 0; i < topping.length; i++){

            if (xPosition > 6){
                xPosition = 0;
                yPosition++;
            }

            if (yPosition > 6){
                yPosition = 0;
            }

            topping[i].style.width  = (pizzaWidth / 6) + 'px';
            topping[i].style.height = (pizzaWidth / 6) + 'px';
            topping[i].style.left   = (xPosition * START_POSITION) * percentAdjustWidth + 'px';
            topping[i].style.top    = (yPosition * START_POSITION) * percentAdjustHeight + 'px';
            
            xPosition++;
        }
    }

    let container = document.getElementById('img-ingredient-container');
    if (container){
        container.style.width  = pizzaWidth + 'px';
        container.style.height = pizzaHeight + 'px';
    }
    
    let subContainer = document.getElementById('img-ingredient-subcontainer');
    if (subContainer){
        subContainer.style.width  = pizzaWidth + 'px';
        subContainer.style.height = pizzaHeight + 'px';
    }

    let sauceContainer = document.getElementById('sauce');
    if (sauceContainer){
        sauceContainer.style.width  = pizzaWidth + 'px';
        sauceContainer.style.height = pizzaHeight + 'px';
    }

    let sauce = document.getElementsByClassName('sauce');
    if (sauce.length > 0){
        sauce[0].style.width  = pizzaWidth + 'px';
        sauce[0].style.height = pizzaHeight + 'px';
    }

    let cheeseContainer = document.getElementById('cheese');
    if (cheeseContainer){
        cheeseContainer.style.width  = pizzaWidth + 'px';
        cheeseContainer.style.height = pizzaHeight + 'px';
    }

    let cheese = document.getElementsByClassName('cheese');
    if (cheese.length > 0){
        for(let i = 0; i < cheese.length; i++){
            cheese[i].style.width  = pizzaWidth + 'px';
            cheese[i].style.height = pizzaHeight + 'px';
        }
    }
}


//Assign click listeners to all ingredient check boxes
for (const [checkboxArrayIndex, element] of Object.entries(ingredients)) {
    ingredients[checkboxArrayIndex].addEventListener(
        'change', 
        () => getImages(ingredients[checkboxArrayIndex].checked, checkboxArrayIndex, element)
    );
}

//Assign click listeners to all ingredient dropdowns
for (const [dropdownArrayIndex] of Object.entries(cheeseSauce)) {
    cheeseSauce[dropdownArrayIndex].addEventListener(
        'change', 
        () => getImages(true, dropdownArrayIndex, cheeseSauce[dropdownArrayIndex])
    );
}


window.addEventListener('resize', () => pizzaSize());