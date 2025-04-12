<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Healthy Habitat Network</a>
        </div>
    </nav>

    <!-- Registration Form -->
    <div class="container my-5">
        <h2>Resident Registration</h2>
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <select class="form-select" id="location" required>
                    <option value="">Select Location</option>
                    <!-- Add locations dynamically -->
                </select>
            </div>
            <div class="mb-3">
                <label for="ageGroup" class="form-label">Age Group</label>
                <select class="form-select" id="ageGroup" required>
                    <option value="18-25">18-25</option>
                    <option value="26-35">26-35</option>
                    <option value="36-45">36-45</option>
                    <option value="46-60">46-60</option>
                    <option value="60+">60+</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="interests" class="form-label">Areas of Interest</label>
                <input type="text" class="form-control" id="interests" required>
            </div>
            <button type="submit" class="btn btn-success">Register</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Healthy Habitat Network. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
