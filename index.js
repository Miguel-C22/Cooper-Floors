import {reviews} from "/reviews.js";
import {carpet, carpetStyles} from "/carpet.js";

const productBtn = document.getElementById("productBtn")
const dropDownLinks = document.getElementById("dropDownLinks")
const hamburgerBtn = document.getElementById("hamburgerBtn")
const navLinks = document.getElementById("navLinks")
const contactLink = document.getElementById("contactLink")
const closeHamburgerBtn = document.getElementById("closeHamburgerBtn")

const carpetModal = document.getElementById('carpetModal')

const customerReviews = document.getElementById("customerReviews")

const emailOutPut = document.getElementById('emailOutPut')

function x(){
    document.querySelector('body').addEventListener('click', event =>{
        modal(event)
        closeModal(event)
        closeEmailOutput(event)
    })
}


//--------------------------Closing Email output-----------------------------
function closeEmailOutput(event){
    if(event.target.id == "closeEmailOutput"){
        emailOutPut.style.display='none'
        emailOutPut.innerHTML = " "
    }   
}

//--------------------------Navigation-----------------------------
function dropDown(){
    productBtn.addEventListener('click', function(){
        dropDownLinks.classList.toggle('dropDownLinksActive')
    })
}

function hamburger(){
    hamburgerBtn.addEventListener('click', function(){
        navLinks.classList.toggle('hamburgerMenuAvtive')
    })
    productBtn.addEventListener('click', function(){
        contactLink.classList.toggle('contactLink')
    })
    closeHamburgerBtn.addEventListener('click', function(){
        navLinks.classList.toggle('hamburgerMenuAvtive')
    })
}


//-----------------------------PhoneNumber---------------------------
// JavaScript for phone number input with automatic hyphens
document.addEventListener('DOMContentLoaded', function () {
    const phoneNumberInput = document.getElementById("phoneNumberInput");

    phoneNumberInput.addEventListener("input", function () {
        const value = phoneNumberInput.value.replace(/\D/g, ""); // Remove non-numeric characters
        if (value.length > 0) {
            phoneNumberInput.value = formatPhoneNumber(value);
        }
    });

    function formatPhoneNumber(value) {
        // Format the phone number with hyphens (e.g., 123-456-7890)
        const match = value.match(/^(\d{0,3})(\d{0,3})(\d{0,4})$/);
        return match ? [match[1], match[2], match[3]].filter(Boolean).join("-") : value;
    }
});


//---------------------Slide Animation------------------------------
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if(entry.isIntersecting) {
            entry.target.classList.add("show")
        }else {
            entry.target.classList.remove('show')
        }
    })
})


const hiddenElements = document.querySelectorAll('.hidden')
hiddenElements.forEach((el)=> observer.observe(el))

//--------------------Customer Reviews---------------------------

//Shuffles the Review Array so evertime the page reloads a different Review appears
const shuffleArray = reviews.sort(() => Math.random() - 0.5)

let i = 0
function reviewSlider(i){
    customerReviews.innerHTML = `
    <div class="customerContainer">
        <h2>Customer Reviews</h2>
        <div class="imgName">
            <img src="${shuffleArray[i].img}" alt="">
            <p>${shuffleArray[i].name}</p>
        </div>
        <div class="review">
            <p><q>${shuffleArray[i].review}</q> </p>
        </div>
    </div>
    `
    
    if( i < reviews.length - 1){
        i++
    }else{
        i = 0
    }
    
}
function slideForward() {
    if (i < reviews.length - 1) {
        i++;
    } else {
        i = 0;
    }
    reviewSlider(i);
}
function slideBackward() {
    if (i > 0) {
        i--;
    } else {
        i = reviews.length - 1;
    }
    reviewSlider(i);
}
// Function to automatically advance the review every 15 seconds





//---------------------------CarpetModal-------------------------------
let carpetName 
let carpetInfo
function modal(event){
    carpet.map((data) => {
        if(event.target.id == data.material){
            carpetName = data.material
            carpetInfo = data.info 
            displayModal()    
        }
    })
    carpetStyles.map((data) => {
        if(event.target.id == data.material){
            carpetName = data.material
            carpetInfo = data.info 
            displayModal()    
        }})
}

function displayModal(){
    carpetModal.style.display='block'
    carpetModal.innerHTML = `
    <button id="closeCarpetModal" class="closeCarpetModal">X</button>
    <h2>${carpetName}</h2>
    <p>${carpetInfo}</p>
    `
}
function closeModal(event){
    if(event.target.id == "closeCarpetModal"){
        carpetModal.style.display='none'
        carpetModal.innerHTML = " "
    }   
}

function render(){
    x()
    //-------------Navigation------------
    dropDown()
    hamburger()
    //-------------Customer Reviews------------
    const forward = document.getElementById('forward')
    const backward = document.getElementById('backward')

    forward.addEventListener('click', function(){
        slideForward()
    })
    backward.addEventListener('click', function(){
        slideBackward()
    })
    function autoAdvanceReview() {
        slideForward();
        setTimeout(autoAdvanceReview, 25000);
    }
    //Initial review display
    reviewSlider(i)
    // Start the auto-advance process
    setTimeout(autoAdvanceReview, 20000);
    
    //Phone Number
  
}

render()












































































