<div class="table-header">
    Chart of account tree
</div>

<?php if (!empty($rootId) && empty($parentId) && empty($childId)):
    ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL</th>
                <th>Root Account</th>
                <th>Parent Account</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rootList as $key => $value): ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $this->Common_model->tableRow('chartofaccount', 'chart_id', $value->parentId)->title; ?></td>
                    <td><?php echo $value->title; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
elseif (!empty($rootId) && !empty($parentId) && empty($childId)):
    ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL</th>
                <th>Root Account</th>
                <th>Parent Account</th>
                <th>Child Account</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($parentList as $key => $value): ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $this->Common_model->tableRow('chartofaccount', 'chart_id', $value->rootId)->title; ?></td>
                    <td><?php echo $this->Common_model->tableRow('chartofaccount', 'chart_id', $value->parentId)->title; ?></td>
                    <td><?php echo $value->title; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Root Account</th>
                <th>Parent Account</th>
                <th>Child Account</th>
                <th>Account Head</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($chartList as $key => $value):
                $parentId = $this->Common_model->tableRow('chartofaccount', 'chart_id', $value->parentId)->parentId;
                ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $this->Common_model->tableRow('chartofaccount', 'chart_id', $value->rootId)->title; ?></td>
                    <td><?php echo $this->Common_model->tableRow('chartofaccount', 'chart_id', $parentId)->title; ?></td>
                    <td><?php echo $this->Common_model->tableRow('chartofaccount', 'chart_id', $value->parentId)->title; ?></td>
                    <td><?php echo $value->title; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>