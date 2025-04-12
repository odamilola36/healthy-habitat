<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../scripts/ds-min.js"></script>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Healthy Habitat Network</a>
        </div>
    </nav>

    <div class="container my-5">
        <h2>Registration</h2>
        <form>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" id="password" required>
            </div>
            <div class="mb-3">
                <label for="re-password" class="form-label">Confirm Password</label>
                <input name="confirm-password" type="password" class="form-control" id="re-password" required>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Telephone</label>
                <input name="telephone" type="text" class="form-control" id="telephone" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input name="address" type="text" class="form-control" id="address" required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input name="city" type="text" class="form-control" id="city" required>
            </div>
            <div class="mb-3">
                <label for="postcode" class="form-label">Postcode</label>
                <input name="postcode" type="text" class="form-control" id="postcode" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" class="form-select" id="role" required onchange="roleSelectAction()">
                    <option value="" disabled selected>Select your role</option>
                    <option value="resident">Resident</option>
                    <option value="business">Business</option>
                    <option value="council">Council</option>
                </select>
            </div>
            <div class="mb-3 d-none resident">
                <label for="firstname" class="form-label">First Name</label>
                <input name="firstname" type="text" class="form-control" id="firstname" required>
            </div>
            <div class="mb-3 d-none resident">
                <label for="lastname" class="form-label">Last Name</label>
                <input name="lastname" type="text" class="form-control" id="lastname" required>
            </div>
            <div class="mb-3 d-none resident">
                <label for="ageGroup" class="form-label">Age Group</label>
                <select name="agegroup" class="form-select" id="ageGroup" required>
                    <option value="18-25">18-25</option>
                    <option value="26-35">26-35</option>
                    <option value="36-45">36-45</option>
                    <option value="46-60">46-60</option>
                    <option value="60+">60+</option>
                </select>
            </div>
            <div class="mb-3 d-none resident">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" class="form-select" id="gender" required>
                    <option value="">select-gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="default">Prefer not to say</option>
                </select>
            </div>
            <div class="mb-3 d-none resident">
                <label for="interests" class="form-label">Areas of Interest</label>
                <select name="interests" class="form-select" id="interests" required multiple>
                    <option value="">select-one-or-more-interests</option>
                </select>
            </div>
            <!-- business fields -->
            <div class="mb-3 d-none business">
                <label for="businessName" class="form-label">Name</label>
                <input name="businessName" type="text" class="form-control" id="businessName" required>
            </div>
            <div class="mb-3 d-none business">
                <label for="regNumber" class="form-label">Registration Number</label>
                <input name="regNumber" type="text" class="form-control" id="regNumber" required>
            </div>

            <!-- council fields -->
            <div class="mb-3 d-none council">
                <label for="councilName" class="form-label">Council name</label>
                <input name="councilName" type="text" class="form-control" id="councilName" required>
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
