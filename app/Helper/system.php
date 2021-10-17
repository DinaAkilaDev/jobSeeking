<?php

function response_api($status, $statusCode, $message, $data)
{
    return response()->json(['status' => $status, 'statusCode' => $statusCode, 'message' => $message, 'items' => $data]);
}
function response_api_pagination($status, $statusCode, $message, $data,$page_number,$total_pages,$total_records)
{
    return response()->json(['status' => $status,
        'statusCode' => $statusCode,
        'message' => $message,
        'items' => ['data' =>$data,
            'page_number' =>$page_number,
            'total_pages' =>$total_pages,
            'total_records' =>$total_records]]);
}
