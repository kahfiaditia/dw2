<title>DHARMAWIDYA</title>
<table border="0">
    @foreach ($items as $item)
        <tr>
            @foreach ($item as $bar)
                <td style="padding: 10px; width:60px; border-bottom-style: dotted; border-bottom-width: 1px;">
                    <?php $data = explode('|--|', $bar); ?>
                    <label style="text-align: justify;">
                        {{ $data[1] }}
                    </label>
                    {!! DNS1D::getBarcodeHTML($data[0], 'C128') !!}
                    {{ $data[0] }}
                </td>
            @endforeach
        </tr>
    @endforeach
</table>
