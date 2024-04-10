document.addEventListener("DOMContentLoaded", function() {
    loadPayments();

    document.getElementById("payment-form").addEventListener("submit", function(event) {
        event.preventDefault();
        let name = document.getElementById("name").value;
        makePayment(name);
    });
});

function loadPayments() {
    fetch("load_payments.php?paid=true")
    .then(response => response.json())
    .then(data => {
        let paymentList = document.getElementById("payment-list");
        paymentList.innerHTML = "<h2>Lista de Pagamentos</h2>";
        if (data.length > 0) {
            let ul = document.createElement("ul");
            data.forEach(payment => {
                let li = document.createElement("li");
                li.textContent = payment.name + " - " + payment.timestamp;
                ul.appendChild(li);
            });
            paymentList.appendChild(ul);
        } else {
            paymentList.innerHTML += "<p>Nenhum pagamento registrado.</p>";
        }
    })
    .catch(error => console.error("Erro ao carregar pagamentos:", error));
}
 function makePayment(name) {
        fetch("make_payment.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({name: name})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Pagamento realizado com sucesso!");
                loadPayments(); // Atualiza a lista de pagamentos após o pagamento ser registrado
            } else {
                alert("Erro ao realizar o pagamento.");
            }
        })
        .catch(error => console.error("Erro ao fazer o pagamento:", error));
    }
    
