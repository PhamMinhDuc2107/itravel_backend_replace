<?php

return [
    // Thông báo hành động thành công
    'success' => [
        'create'  => 'Tạo mới thành công.',
        'update'  => 'Cập nhật thành công.',
        'delete'  => 'Xóa dữ liệu thành công.',
        'restore' => 'Khôi phục dữ liệu thành công.',
        'send'    => 'Gửi thành công.',
        'upload'  => 'Tải lên thành công.',
        'login'   => 'Đăng nhập thành công.',
        'logout'  => 'Đăng xuất thành công.',
    ],

    // Thông báo lỗi
    'error' => [
        'not_found'    => 'Không tìm thấy dữ liệu.',
        'unauthorized' => 'Bạn không có quyền truy cập.',
        'forbidden'    => 'Hành động bị cấm.',
        'bad_request'  => 'Yêu cầu không hợp lệ.',
        'server'       => 'Lỗi máy chủ nội bộ.',
        'token_invalid'=> 'Token không hợp lệ hoặc đã hết hạn.',
        'login_failed' => 'Thông tin đăng nhập không chính xác.',
    ],

    // Các nhãn chung (Labels)
    'labels' => [
        'active'   => 'Đang hoạt động',
        'inactive' => 'Ngừng kích hoạt',
        'banned'   => 'Đã bị khóa',
        'draft'    => 'Bản nháp',
        'pending'  => 'Đang chờ xử lý',
    ]
];
