(function($){var initPopover=function(element){let current=(element.currentTarget)?element.currentTarget:element;let popover=$(current).find("[data-toggle='popover']");if(popover.length){popover.on("click",(e)=>e.preventDefault()).popover()}};$(document).on("updated.pageWidget",".widget",(el)=>initPopover(el));$(document).ready(()=>initPopover(document.querySelector("body")))})(jQuery)