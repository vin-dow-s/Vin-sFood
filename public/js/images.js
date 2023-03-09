window.onload = () => {
    //Gestion des liens "Supprimer"
    let links = document.querySelectorAll("[data-delete]");

    //On boucle sur ces liens
    for(let link of links){
        link.addEventListener("click",  function (e){
            //On empêche la navigation
            e.preventDefault();
            //On demande confirmation
            if(confirm("Supprimer cette image ?")){
                //On envoie une requête AJAX vers le href du lien avec la méthode DELETE
                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({"_token": this.dataset.token})
                }).then(
                    //On récupère la réponse en JSON
                    response => response.json()
                ).then(data => {
                    if(data.success)
                        this.parentElement.remove();
                    else
                        alert(data.error);
                }).catch(e => alert(e))
            }
        })
    }
}