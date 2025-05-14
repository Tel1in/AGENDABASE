<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <title>NIP</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div id="nipSection" class="card p-5">
            <h2 class="card-title text-center">Ingrese su NIP</h2>
            <div class="card-body">
                <form id="nipForm">
                    <div class="mb-3">
                        <input type="password" class="form-control" id="nipInput" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Acceder</button>
                    </div>
                </form>
                <div id="errorMessage" class="mt-3 text-danger"></div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('nipForm').addEventListener('submit', function(e) {
            e.preventDefault();
            verificarNIP();
        });

        function verificarNIP() {
            var nip = document.getElementById('nipInput').value;
            fetch('sesion.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'nip=' + encodeURIComponent(nip)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'agenda.php';
                } else {
                    document.getElementById('errorMessage').textContent = data.message;
                    document.getElementById('nipInput').value = '';
                }
            })
            .catch(error => {
                document.getElementById('errorMessage').textContent = 'Ocurrió un error al verificar el NIP.';
                console.error('Error al verificar el NIP:', error);
            });
        }
    </script>
</body>
</html>