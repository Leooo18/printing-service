document.getElementById("login-btn").addEventListener("click", loginAdmin);

let adminUserId = null;

// Function to handle admin login
function loginAdmin() {
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;

  // Simple validation (you can improve it)
  if (!email || !password) {
    document.getElementById("login-error").innerText = "Please enter both email and password.";
    document.getElementById("login-error").style.display = "block";
    return;
  }

  // Make a request to the backend for authentication
  axios.post("http://localhost:5000/api/login", { email, password })
    .then(response => {
      const { message, user_id } = response.data;
      if (message === "Login successful") {
        adminUserId = user_id;
        document.getElementById("login-section").style.display = "none";
        document.getElementById("dashboard-section").style.display = "block";
        fetchOrders();
      } else {
        document.getElementById("login-error").innerText = "Invalid credentials. Please try again.";
        document.getElementById("login-error").style.display = "block";
      }
    })
    .catch(error => {
      console.error(error);
      document.getElementById("login-error").innerText = "Something went wrong. Please try again.";
      document.getElementById("login-error").style.display = "block";
    });
}

// Function to fetch orders from the backend
function fetchOrders() {
  axios.get("http://localhost:5000/api/orders")
    .then(response => {
      const orders = response.data;
      const tableBody = document.getElementById("orders-table").getElementsByTagName("tbody")[0];
      tableBody.innerHTML = ""; // Clear any existing rows

      orders.forEach(order => {
        const row = tableBody.insertRow();
        row.innerHTML = `
          <td>${order.full_name}</td>
          <td>${order.payment_date}</td>
          <td>${order.order_status}</td>
          <td>
            <button onclick="updateOrderStatus(${order.payment_id}, 'Completed')">Complete</button>
            <button onclick="updateOrderStatus(${order.payment_id}, 'Cancelled')">Cancel</button>
          </td>
        `;
      });
    })
    .catch(error => {
      console.error(error);
    });
}

// Function to update the order status
function updateOrderStatus(paymentId, status) {
  axios.post("http://localhost:5000/api/update-order-status", { payment_id: paymentId, order_status: status })
    .then(response => {
      alert(response.data.message);
      fetchOrders(); // Re-fetch orders after updating status
    })
    .catch(error => {
      console.error(error);
      alert("Something went wrong while updating the order status.");
    });
}
