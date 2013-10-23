<table>
    <thead>
        <tr>
        <?php foreach($thead->getColumns() as $column): ?>
            <th><?php echo $column->render(); ?></th>
        <?php endforeach; ?>
        </tr>
    </thead>

    <tbody>
    <?php foreach($tbody->getRows() as $dataRow): ?>
        <tr>
            <?php foreach ($dataRow->getData() as $td): ?>
                <td>
                    <?php echo $td; ?>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>