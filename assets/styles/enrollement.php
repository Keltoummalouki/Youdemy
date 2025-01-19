/* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
}

.enrollments-container {
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Table Styles */
.enrollments-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.enrollments-table th,
.enrollments-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.enrollments-table th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}

.enrollments-table tr:hover {
    background-color: #f1f1f1;
}

.enrollments-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* No Data Message */
.no-data {
    text-align: center;
    color: #888;
    font-style: italic;
    padding: 20px;
}