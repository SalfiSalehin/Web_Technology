function loadData() {
    var xhr = new XMLHttpRequest();

    xhr.open("GET", "data.php", true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            var students = JSON.parse(xhr.responseText);

            var output = "";

            students.forEach(function(student) {
                output += `
                    <div class="card">
                        <div class="title">${student.name}</div>
                        <p><strong>ID:</strong> ${student.id}</p>
                        <p><strong>Department:</strong> ${student.department}</p>
                        <p><strong>CGPA:</strong> ${student.cgpa}</p>
                    </div>
                `;
            });

            document.getElementById("result").innerHTML = output;
        }
    };

    xhr.send();
}