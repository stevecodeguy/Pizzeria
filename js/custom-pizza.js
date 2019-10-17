let ingredients = document.getElementsByClassName('wc-pao-addon-checkbox');
let cheeseDropdown = document.getElementsByName('addon-103-cheese-1');
let sauceDropdown = document.getElementsByName('addon-103-sauce-0');
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

let loadingFront = document.getElementById('loading-front');
let loadingBack = document.getElementById('loading-back');

loadingFront.style['position']  = 'absolute';
loadingFront.style['left']      = '50%';
loadingFront.style['top']       = '50%';
loadingFront.style['transform'] = 'translate(-50%, -50%)';
loadingFront.style['display']   = 'block';
loadingFront.style['width']     = pizzaWidth * 0.5 + 'px';
loadingFront.style['height']    = pizzaWidth * 0.5 + 'px';

loadingBack.style['position']  = 'absolute';
loadingBack.style['left']      = '50%';
loadingBack.style['top']       = '50%';
loadingBack.style['transform'] = 'translate(-50%, -50%)';
loadingBack.style['display']   = 'block';
loadingBack.style['width']     = pizzaWidth * 0.5 + 'px';
loadingBack.style['height']    = pizzaWidth * 0.5 + 'px';

document.getElementById('img-ingredient-subcontainer').appendChild(loadingFront);
document.getElementById('img-ingredient-subcontainer').appendChild(loadingBack);

let restAPIData = new Array();
let ingredientObjects = new Array();

hideShowControls(ingredients, 0.2);
hideShowControls(cheeseDropdown, 0.2);
hideShowControls(sauceDropdown, 0.2);

fetchData();

function hideShowControls(item, hideShow){
    for (let i = 0; i < item.length; i++){
        item[i].parentNode.style['opacity'] = hideShow;
        if (hideShow < 1){
            item[i].disabled = 'disabled';
        } else {
            item[i].disabled = false;
        }
    };
}

function fetchData(){
    fetch('https://pizzeria.bcitwebdeveloper.ca/wp-json/wp/v2/media?per_page=100&slug=red-onions,tomatoes,feta,parmesan,pineapple,onions,mushrooms,pizza-crust,provolone,mozzarella-and-cheddar-blend,mozzarella,cheddar,roasted-red-peppers,salami,sausage,organic-tomato-sauce,pepperoni,fresh-salsa,salmon,black-olives,cheesy-cheddar-sauce,green-olives,alfredo-sauce,roasted-corn,barbeque-sauce,anchovies,jalapeno-peppers,baby-spinach,green-peppers,hot-banana-peppers,chicken,philly-steak,ground-beef,canadian-ham,bacon,beyond-meat')
        .then(response => response.json())
        .then((data) => {
            data.map((ingredient) => {
                let topping = {
                    slug: ingredient.slug,
                    source_url: ingredient.source_url
                }

                restAPIData.push(topping);
            })
        })
        .then(() => {
            for (let i = 0; i < restAPIData.length; i++){

                for (let x = 0; x < ingredients.length; x++){
                    if (restAPIData[i].slug === ingredients[x].value){
                        ingredientObjects.push(restAPIData[i]);
                        break;
                    }
                }

                for (let y = 0; y < cheeseDropdown[0].options.length; y++){
                    if (restAPIData[i].slug === cheeseDropdown[0].options[y].value.slice(0, -2)){
                        ingredientObjects.push(restAPIData[i]);
                        break;
                    }
                }

                for (let z = 0; z < sauceDropdown[0].options.length; z++){
                    
                    if (restAPIData[i].slug === sauceDropdown[0].options[z].value.slice(0, -2)){
                        ingredientObjects.push(restAPIData[i]);
                        break;
                    }
                }
                
                if (restAPIData[i].slug === 'pizza-crust'){
                    ingredientObjects.push(restAPIData[i]);
                }
                delete restAPIData[i];
            }
        })
        .then(() => {
            hideShowControls(ingredients, 1);
            hideShowControls(cheeseDropdown, 1);
            hideShowControls(sauceDropdown, 1);
            loadingFront.parentNode.removeChild(loadingFront);
            loadingBack.parentNode.removeChild(loadingBack);
        })
        .then(() => console.log(ingredientObjects, ingredientObjects.length))
        .catch(error => alert(error));
    }


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

    let checkedIngredient = element.value;
    let slug     = '';
    let url      = '';

    ingredientObjects.find((item) => {
        if (item.slug === 'pizza-crust'){
            if (document.getElementsByClassName('crust').length == 0){
                addCrust(item.source_url);
            }
        }
    });

    ingredientObjects.find((item) => {
        if (item.slug === checkedIngredient.replace(' ', '-') || 
            item.slug === checkedIngredient.slice(0, -2)){

            slug = item.slug;
            url  = item.source_url;
        }
    });

    switch (slug) {
    case 'cheddar':
    case 'provolone':
    case 'mozzarella':
    case 'mozzarella-and-cheddar-blend':
    case 'feta':
    case 'parmesan':
        removeIngredient('cheese');
        addCheeseOrSauce(url, 'cheese', 2);
        break;
    case 'alfredo-sauce':
    case 'barbeque-sauce':
    case 'cheesy-cheddar-sauce':
    case 'fresh-salsa':
    case 'organic-tomato-sauce':
        removeIngredient('sauce');
        addCheeseOrSauce(url, 'sauce', 1);
        break;
    default:
        if (checked){
            addIngredient(url, index);
        } else {
            removeIngredient(slug);
        }
    }
}


function removeIngredient(removedIngredient) {
    //remove ingredient images
    let ingredient = document.getElementById(removedIngredient);

    if (ingredient) {
        ingredient.parentNode.removeChild(ingredient);
    }
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
    if (ingredients[index].checked === true || cheeseSauce[index].selected === true){
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
    if (document.getElementById(cheeseOrSauce)){
        removeIngredient(cheeseOrSauce);
    }

    let sauceCheeseContainer = document.createElement('div');

    sauceCheeseContainer.id                  = cheeseOrSauce;
    sauceCheeseContainer.style['width']      = pizzaWidth + 'px';
    sauceCheeseContainer.style['height']     = pizzaWidth + 'px';
    sauceCheeseContainer.style['position']   = 'absolute';
    sauceCheeseContainer.style['top']        = '0';
    sauceCheeseContainer.style['left']       = '0';

    document.getElementById('img-ingredient-container').appendChild(sauceCheeseContainer);    

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
    crust.style['max-width']  = '100%';

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
cheeseDropdown[0].addEventListener('change', () => getImages(true, 0, cheeseDropdown[0]));
sauceDropdown[0].addEventListener('change', () => getImages(true, 0, sauceDropdown[0]));


window.addEventListener('resize', () => pizzaSize());