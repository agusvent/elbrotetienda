<div class="card">
    <div class="card-body">
        <table id="fullOrdersTable">
            <thead>
                <tr>
                    <?php foreach($orders['columns'] as $column): ?>
                    <th><?=$column;?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orders['rows'] as $row): ?>
                <tr>
                    <?php foreach($row as $rowValue): ?>
                    <td><?=$rowValue;?></td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>