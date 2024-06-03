import { viewmenuicon, viewusericon, viewsearch} from "./viewicon.js";
import {previewBeforeUpload} from "./preview.js";
import {ratingSystem} from "./ratingSystem.js";

document.addEventListener("DOMContentLoaded", (e)=>{
    ratingSystem();
    viewsearch();
    viewmenuicon();
    viewusericon();
const previewRectte=document.querySelector("#img_recette")
    if(previewRectte){
        previewBeforeUpload("img_recette");
    }
    const previewAvatar=document.querySelector("#avatar-user")
    if( previewAvatar)(
        previewBeforeUpload("avatar-user")
    )
    const previewPays=document.querySelector("#img_pays")
    if( previewPays)(
        previewBeforeUpload("img_pays")
    )


})