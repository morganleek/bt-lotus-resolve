/*!
 * 
 * bonesTheme
 * 
 * @author 
 * @version 0.1.0
 * @link UNLICENSED
 * @license UNLICENSED
 * 
 * Copyright (c) 2024 
 * 
 * This software is released under the UNLICENSED License
 * https://opensource.org/licenses/UNLICENSED
 * 
 * Compiled with the help of https://wpack.io
 * A zero setup Webpack Bundler Script for WordPress
 */
(window.wpackiobonesThemeappJsonp=window.wpackiobonesThemeappJsonp||[]).push([[0],{3:function(e,t,o){o(4),e.exports=o(5)},5:function(e,t,o){"use strict";o.r(t);var r=o(1),a=o(2);r.a.registerPlugin(a.a),document.addEventListener("DOMContentLoaded",(function(){document.querySelectorAll('a[rel="external"]').forEach((function(e){e.target="_blank"}));var e=r.a.matchMedia();e.add("(max-width: 799px)",(function(){if(document.querySelector("header.wp-block-template-part")){document.querySelector("header.wp-block-template-part .floating-menu")&&document.querySelector("header.wp-block-template-part .floating-menu").offsetTop;r.a.timeline({scrollTrigger:{trigger:document.querySelector("header.wp-block-template-part"),endTrigger:document.querySelector("footer"),start:"10px top",end:"bottom top",scrub:!0,toggleClass:{targets:document.body,className:"is-fixed"}}})}})),e.add("(min-width: 800px)",(function(){if(document.querySelector("header.wp-block-template-part")){var e=document.querySelector("header.wp-block-template-part .floating-menu")?document.querySelector("header.wp-block-template-part .floating-menu").offsetTop-10:44;r.a.timeline({scrollTrigger:{trigger:document.querySelector("header.wp-block-template-part"),endTrigger:document.querySelector("footer"),start:e+"px top",end:"bottom top",scrub:!0,toggleClass:{targets:document.body,className:"is-fixed"}}})}})),document.querySelectorAll(".wp-block-group.employee-profile-stack > .wp-block-group > p, .wp-block-group.employee-profile-stack > .wp-block-image").forEach((function(e){e.addEventListener("click",(function(e){e.target.closest(".employee-profile-stack").classList.toggle("is-active")}))})),window.addEventListener("resize",(function(){c()})),c(),document.querySelectorAll('img[loading="lazy"]').forEach((function(e){1==e.complete&&e.classList.add("has-loaded"),e.addEventListener("load",(function(e){e.target.classList.add("has-loaded")}))}))}));var c=function(){document.documentElement.style.setProperty("--app--height","".concat(window.innerHeight,"px")),document.querySelector("header")&&document.documentElement.style.setProperty("--app--header--height","".concat(document.querySelector("header").offsetHeight,"px"))}}},[[3,1,2]]]);
//# sourceMappingURL=main-d4c8049c.js.map