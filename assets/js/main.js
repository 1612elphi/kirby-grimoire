
import jQuery from 'jquery';
import { Fancybox } from "@fancyapps/ui";

window.$ = window.jQuery = jQuery;

// Initialize Fancybox
Fancybox.bind("[data-fancybox]", {
  // Your custom options
});

// Your custom JavaScript code here
function toggleFullScreen() {
  if (!document.fullscreenElement) {
    if (document.documentElement.requestFullscreen) {
      document.documentElement.requestFullscreen();
    }
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    }
  }
}