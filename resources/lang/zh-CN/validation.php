<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted'             => ':attribute 必须接受。',
    'active_url'           => ':attribute 不是一个有效的网址。',
    'after'                => ':attribute 必须是一个在 :date 之后的日期。',
    'alpha'                => ':attribute 只能由字母组成。',
    'alpha_dash'           => ':attribute 只能由字母、数字和斜杠组成。',
    'alpha_num'            => ':attribute 只能由字母和数字组成。',
    'array'                => ':attribute 必须是一个数组。',
    'before'               => ':attribute 必须是一个在 :date 之前的日期。',
    'between'              => [
        'numeric' => ':attribute 必须介于 :min - :max 之间。',
        'file'    => ':attribute 必须介于 :min - :max kb 之间。',
        'string'  => ':attribute 必须介于 :min - :max 个字符之间。',
        'array'   => ':attribute 必须只有 :min - :max 个单元。',
    ],
    'boolean'              => ':attribute 必须为布尔值。',
    'confirmed'            => ':attribute 两次输入不一致。',
    'date'                 => ':attribute 不是一个有效的日期。',
    'date_format'          => ':attribute 的格式必须为 :format。',
    'different'            => ':attribute 和 :other 必须不同。',
    'digits'               => ':attribute 必须是 :digits 位的数字。',
    'digits_between'       => ':attribute 必须是介于 :min 和 :max 位的数字。',
    'dimensions'           => ':attribute 图片尺寸不正确。',
    'distinct'             => ':attribute 已经存在。',
    'email'                => ':attribute 不是一个合法的邮箱。',
    'exists'               => ':attribute 不存在。',
    'file'                 => ':attribute 必须是文件。',
    'filled'               => ':attribute 不能为空。',
    'image'                => ':attribute 必须是图片。',
    'in'                   => '已选的属性 :attribute 非法。',
    'in_array'             => ':attribute 没有在 :other 中。',
    'integer'              => ':attribute 必须是整数。',
    'ip'                   => ':attribute 必须是有效的 IP 地址。',
    'json'                 => ':attribute 必须是正确的 JSON 格式。',
    'max'                  => [
        'numeric' => ':attribute 不能大于 :max。',
        'file'    => ':attribute 不能大于 :max kb。',
        'string'  => ':attribute 不能大于 :max 个字符。',
        'array'   => ':attribute 最多只有 :max 个单元。',
    ],
    'mimes'                => ':attribute 必须是一个 :values 类型的文件。',
    'min'                  => [
        'numeric' => ':attribute 必须大于等于 :min。',
        'file'    => ':attribute 大小不能小于 :min kb。',
        'string'  => ':attribute 至少为 :min 个字符。',
        'array'   => ':attribute 至少有 :min 个单元。',
    ],
    'not_in'               => '已选的属性 :attribute 非法。',
    'numeric'              => ':attribute 必须是一个数字。',
    'present'              => ':attribute 必须存在。',
    'regex'                => ':attribute 格式不正确。',
    'required'             => ':attribute 不能为空。',
    'required_if'          => '当 :other 为 :value 时 :attribute 不能为空。',
    'required_unless'      => '当 :other 不为 :value 时 :attribute 不能为空。',
    'required_with'        => '当 :values 存在时 :attribute 不能为空。',
    'required_with_all'    => '当 :values 存在时 :attribute 不能为空。',
    'required_without'     => '当 :values 不存在时 :attribute 不能为空。',
    'required_without_all' => '当 :values 都不存在时 :attribute 不能为空。',
    'same'                 => ':attribute 和 :other 必须相同。',
    'size'                 => [
        'numeric' => ':attribute 大小必须为 :size。',
        'file'    => ':attribute 大小必须为 :size kb。',
        'string'  => ':attribute 必须是 :size 个字符。',
        'array'   => ':attribute 必须为 :size 个单元。',
    ],
    'string'               => ':attribute 必须是一个字符串。',
    'timezone'             => ':attribute 必须是一个合法的时区值。',
    'unique'               => ':attribute 已经存在。',
    'url'                  => ':attribute 格式不正确。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention 'attribute.rule' to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of 'email'. This simply helps us make messages a little cleaner.
    |
    */

    'attributes'           => [
        'user'                  => '用户名',
        'cname'                 => '名称',
        'name'                  => '名称',
        'username'              => '用户名',
        'email'                 => '邮箱',
        'first_name'            => '名',
        'last_name'             => '姓',
        'password'              => '密码',
        'password_confirmation' => '确认密码',
        'city'                  => '城市',
        'country'               => '国家',
        'address'               => '地址',
        'phone'                 => '电话',
        'mobile'                => '手机',
        'age'                   => '年龄',
        'sex'                   => '性别',
        'gender'                => '性别',
        'day'                   => '天',
        'month'                 => '月',
        'year'                  => '年',
        'hour'                  => '时',
        'minute'                => '分',
        'second'                => '秒',
        'title'                 => '标题',
        'content'               => '内容',
        'description'           => '描述',
        'excerpt'               => '摘要',
        'date'                  => '日期',
        'time'                  => '时间',
        'available'             => '可用的',
        'size'                  => '大小',
        'remark'                => '备注',
        'unit_name'             => '上级节点单位名称',
        'purview'               => '权限',
        'market_name'           =>  '市场名称',
        'father_id'             => '上级节点',
        'role_id'               => '角色',
        'cess'             => '税率',
        'stock_name'            => '库存类型',
        'store_id'              => '店面',
        'type_id'               => '类型',
        'classify_id'           => '分类',
        'brand_id'              => '品牌',
        'standard'              => '标品/散货',
        'cart_type_name'        => '车辆类型',
        'cart_source_name'      => '车辆来源',
        'shelf_life'            => '保质期',
        'spec'                  => '规格',
        'images'                => '图片',
        'supplier_name'         => '供应商名称',
        'supplier_type'         => '供应商类型',
        'user_name'             => '联系人',
        'tel'                   => '手机号码',
        'payer'                 => '付款供应商',
        'payee'                 => '收款方名称',
        'card_number'           => '收款卡号',
        'bank_account'          => '开户行',
        'city_id'               => '城市',
        'market_id'             => '市场',
        'type'                  => '类型',
        'rc_id'                 => '仓库',
        'account'               => '账户',
        'region'                => '所属区域',
        'coordinate'            => '地图坐标',
        'linkman'               => '联系人',
        'product_num'           => '产品名称',
        'reperstory'            => '仓库',
        'choice_market'         => '备货采购市场',
        'choice_buy_price'      => '备货采购定价',
        'choice_single_price'   => '备货单品销售限价',
        'choice_pack_price'     => '备货打包销售限价',
        'temporary_market'      => '临时采购市场',
        'temporary_buy_price'   => '临时采购定价',
        'temporary_single_price' => '临时单品销售限价',
        'temporary_pack_price'  => '临时打包销售限价',
        'img_class'             => '图标样式',
        'repertory_id'          => '仓库',
        'order_status'          => '订单状态',
        'startTime'             => '开始时间',
        'endTime'               => '结束时间',
        'order_type'            => '订单来源',
        'id'                    => '编号',
        'add_user_id'           => '销售员',
        'pay_status'            => '支付状态',
        'client_id'             => '客户编号',
        'client_name'           => '客户姓名',
        'region_id'             => '片区',
        'bank'                  => '银行',
        'out_city_id'           => '调出城市',
        'out_repertory_id'      => '调出仓库',
        'in_city_id'            => '调入城市',
        'in_repertory_id'       => '调入仓库',
        'goods_id'              => '商品',
        'allot_number'          => '调拨数量',
        'choice_supplier'       => '备货默认供应商',
        'rid'                   => '仓库',
        'car_source_id'         => '车辆来源',
        'driver_guid'           => '司机',
        'car_type_id'           => '车辆类型',
        'car_number'            => '车牌号',
        'side_limit'            => '限方',
        'weight_limit'          => '限重',
        'length'                => '车长',
        'width'                 => '车宽',
        'height'                => '车高',
        'car_price'             => '车辆价格',
        'x'                     => 'x坐标',
        'y'                     => 'y坐标',
        'where_reperstory'      => '仓库',
        'org_id'                => '组织',
        'gotime'                => '到达时间',
        'storage_area_name'     => '货位区名称',
        'area_no'               => '货位区编号',
        'sort'                  => '序号',
        'short_name'            => '简拼',
        'pay_supplier_id'       => '付款供应商',
        'pay_type'              => '付款方式',
        'pay_money'             => '付款金额',
        'end_time'              => '结束时间',
        'start_time'            => '开始时间',
        'ruling_price'          => '优惠价',
        'active_num'            => '参加活动数量',
        'buy_num'               => '购买数量',
        'area_id'               => '片区',
        'pay_date'              => '付款日期',
        'original_price'        => '原价',
        'icon'                  =>  '图标',
        'route_alias'           =>  '路由别名',
        'route'                 =>  '路由',
        'pid'                   =>  '上级栏目',
        'order_by'              =>  '排序值',
        'thumb'                 =>  '图片',
        'price'                 =>  '价格'
    ],
];