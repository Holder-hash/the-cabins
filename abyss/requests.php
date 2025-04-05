<?php
require_once '../api/db.php';

$sql = "SELECT id, phone, status FROM requests";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styles/abyss.css" />
  <title>Abyss</title>

  <style>
    h1 {
      text-align: center;
      color: #00aaff;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      max-width: 800px;
      margin: 0 auto;
    }

    th,
    td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #00aaff;
      color: #fff;
      cursor: pointer;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .complete-btn {
      background-color: #00aaff;
      color: #fff;
      border: none;
      padding: 8px 12px;
      cursor: pointer;
      border-radius: 4px;
    }

    .complete-btn:hover {
      background-color: #008ccc;
    }

    .status-cell {
      transition: background-color 0.3s;
    }

    main {
      margin: 20px auto;
    }
  </style>
</head>

<body>
  <header>
    <img src="../media/logo-transparent.png" alt="" />
    Abyss
  </header>

  <div class="wrapper">
    <aside>
      <nav>
        <ul>
          <li>Прайс</li>
          <li>Группы</li>
          <li>Заявки</li>
        </ul>
      </nav>
    </aside>

    <main>
      <h1>Список заявок</h1>

      <table id="requestsTable">
        <thead>
          <tr>
            <th data-column="id">ID</th>
            <th data-column="phone">Телефон</th>
            <th data-column="status">Статус</th>
            <th>Действие</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr data-id="<?= $row['id'] ?>">
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td class="status-cell"><?= htmlspecialchars($row['status']) ?></td>
                <td><button class="complete-btn">Завершить</button></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="4">Нет заявок</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </main>
  </div>

  <script>
    const table = document.getElementById('requestsTable');
    const headers = table.querySelectorAll('th[data-column]');

    headers.forEach(header => {
      header.addEventListener('click', () => {
        const column = header.getAttribute('data-column');
        sortTableByColumn(table, column);
      });
    });

    function sortTableByColumn(table, column) {
      const tbody = table.querySelector('tbody');
      const rows = Array.from(tbody.querySelectorAll('tr'));

      let columnIndex = 0;
      switch (column) {
        case 'id':
          columnIndex = 0;
          break;
        case 'phone':
          columnIndex = 1;
          break;
        case 'status':
          columnIndex = 2;
          break;
      }

      const isAscending = table.getAttribute(`data-sort-${column}`) === 'asc';
      table.setAttribute(`data-sort-${column}`, isAscending ? 'desc' : 'asc');

      rows.sort((a, b) => {
        const aText = a.children[columnIndex].textContent.trim();
        const bText = b.children[columnIndex].textContent.trim();

        if (column === 'id') {
          return isAscending ? (aText - bText) : (bText - aText);
        } else {
          return isAscending ? aText.localeCompare(bText) : bText.localeCompare(aText);
        }
      });

      rows.forEach(row => tbody.appendChild(row));
    }

    const completeButtons = document.querySelectorAll('.complete-btn');
    completeButtons.forEach(btn => {
      btn.addEventListener('click', (e) => {
        const row = e.target.closest('tr');
        const requestId = row.getAttribute('data-id');

        fetch('https://oleg-diplom.local/api/requests/complete_request.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + encodeURIComponent(requestId)
          })
          .then(response => response.text())
          .then(result => {
            console.log('Ответ сервера:', result);

            const statusCell = row.querySelector('.status-cell');
            statusCell.textContent = 'done';
            statusCell.style.backgroundColor = '#c2f0c2';
          })
          .catch(error => {
            console.error('Ошибка:', error);
            alert('Не удалось изменить статус.');
          });
      });
    });
  </script>
</body>

</html>