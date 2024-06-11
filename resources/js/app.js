import './bootstrap';
import 'preline'; // Configuring the preline framework for tailwind css.

document.addEventListener('livewire:navigated', () => { // Fixing the bug when we on the mobile screen size and we want to choose one of the navbar items(Home, Categories ,Products ,Cart ,Log in) or any page we used 'livewire:navigate' inside it, the navbar menu is not showing, so we will add an events listener to initialize the preline components(the navbar was developed using preline).
    window.HSStaticMethods.autoInit();
});
