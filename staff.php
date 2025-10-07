    <?php if (!empty($success)): ?>
    <div class="panel success" role="status"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <?php foreach ($errors as $err): ?>
        <div class="panel error" role="alert"><?= htmlspecialchars($err) ?></div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Add Staff Form -->
<section class="panel" aria-labelledby="add-staff-title">
    <h2 id="add-staff-title" style="margin-top:0;">Add Staff Member</h2>
    <form method="post" action="index.php?page=staff_management" autocomplete="off">
        <input type="hidden" name="action" value="add_staff">
        <label>
            Name:
            <input type="text" name="staff_name" placeholder="Full name" required>
        </label><br>
        <label>
            Username:
            <input type="text" name="username" placeholder="Username" required>
        </label><br>
        <label>
            Password:
            <input type="password" name="password" placeholder="Password" required>
        </label><br>
        <button class="btn primary" type="submit">Add Staff</button>
    </form>
</section>

<!-- Staff List and Remove -->
<section class="panel" aria-labelledby="staff-list-title">
    <h2 id="staff-list-title" style="margin-top:0;">Staff List</h2>
    <table aria-label="Staff accounts">
        <thead>
            <tr>
                <th>Staff ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($staffs)): ?>
                <?php foreach ($staffs as $s): ?>
                    <tr>
                        <td><?= htmlspecialchars($s['StaffID']) ?></td>
                        <td><?= htmlspecialchars($s['StaffName']) ?></td>
                        <td><?= htmlspecialchars($s['Username']) ?></td>
                        <td><?= htmlspecialchars($s['CreatedAt']) ?></td>
                        <td>
                            <form method="post" action="index.php?page=staff_management" style="display:inline;">
                                <input type="hidden" name="action" value="remove_staff">
                                <input type="hidden" name="staff_id" value="<?= htmlspecialchars($s['StaffID']) ?>">
                                <button class="btn danger" type="submit" onclick="return confirm('Remove this staff member? This cannot be undone.');">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align:center;">No staff accounts found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>