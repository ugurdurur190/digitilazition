var mini = true;

function toggleSidebar() {
    if (mini) {
        console.log("opening sidebar");
        document.getElementById("mySidebar").style.width = "225px";
        document.getElementById("main").style.marginLeft = "125px";
        this.mini = false;
    } else {
        console.log("closing sidebar");
        document.getElementById("mySidebar").style.width = "65px";
        document.getElementById("main").style.marginLeft = "65px";
        this.mini = true;
    }
}