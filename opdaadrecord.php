<!DOCTYPE html>
<html>
<head>
    <title>Hospital Admission and Discharge Form</title>
    <style>
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 6px; margin-top: 4px; }
        .row { display: flex; gap: 10px; }
        .row > div { flex: 1; }
    </style>
</head>
<body>
    <h2>Ospital ng Tagaytay - Admission and Discharge Record</h2>
    <form action="submit.php" method="POST">
        <div class="row">
            <div><label>Hospital Code</label><input name="hospital_code" type="text"></div>
            <div><label>Medical Record No.</label><input name="record_no" type="text"></div>
        </div>

        <label>Patient Name</label>
        <div class="row">
            <div><input name="lastname" placeholder="Last Name" type="text"></div>
            <div><input name="firstname" placeholder="Given Name" type="text"></div>
            <div><input name="middlename" placeholder="Middle Name" type="text"></div>
        </div>

        <label>Ward/Services</label><input name="ward_services" type="text">

        <label>Permanent Address</label><input name="address" type="text">

        <label>Sex</label>
        <select name="sex">
            <option>Male</option>
            <option>Female</option>
        </select>

        <label>Civil Status</label>
        <select name="civil_status">
            <option>Single</option>
            <option>Married</option>
            <option>Widow/Widower</option>
            <option>Separated</option>
        </select>

        <div class="row">
            <div><label>Birthdate</label><input name="birthdate" type="date"></div>
            <div><label>Birthplace</label><input name="birthplace" type="text"></div>
        </div>

        <label>Nationality</label><input name="nationality" type="text">
        <label>Religion</label><input name="religion" type="text">

        <label>Employer (Type of Business)</label><input name="employer" type="text">
        <label>Employer Address</label><input name="employer_address" type="text">
        <label>Employer Telephone</label><input name="employer_tel" type="text">

        <label>Father's Name</label><input name="father_name" type="text">
        <label>Father's Address</label><input name="father_address" type="text">
        <label>Father's Telephone</label><input name="father_tel" type="text">

        <label>Admission Diagnosis</label><textarea name="diagnosis"></textarea>

        <label>Attending Physician</label><input name="physician" type="text">

        <br><button type="submit">Submit</button>
    </form>
</body>
</html>