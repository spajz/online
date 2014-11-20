<p>You have received a new photo.</p>

<table border="1" cellspacing="0" cellpadding="4">
    <tr>
        <td><b>ID</b></td>
        <td>{{ $item->id }}</td>
    </tr>
    <tr>
        <td><b>Full Name</b></td>
        <td>{{ $item->full_name }}</td>
    </tr>
    <tr>
        <td><b>Text</b></td>
        <td>{{ $item->description }}</td>
    </tr>
    <tr>
        <td><b>User IP</b></td>
        <td>{{ $item->ip }}</td>
    </tr>
</table>

