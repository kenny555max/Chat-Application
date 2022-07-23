console.log("Live reload enabled!");

const searchInput = document.getElementById("searchInput");
const userConnection = document.querySelector(".user-connection");

searchInput.addEventListener("keyup", e => {
    let filterText = e.target.value.toLowerCase();

    let profiles = userConnection.querySelectorAll(".profile");

    for (const profile of profiles) {
        let name = profile.querySelector(".name").textContent;

        if (name.toLowerCase().indexOf(filterText) != -1) {
            profile.style.display = "block";
        }else{
            profile.style.display = "none";
        }
    }
});