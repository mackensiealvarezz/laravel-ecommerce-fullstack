import React from 'react';
import Authenticated from '@/Layouts/Authenticated';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import Pagination from '@/Components/Pagination';
import Button from '@/Components/Button';
import FlashMessage from '@/Components/FlashMessage';
import Input from '@/Components/Input';
import formatCentsToDollars from '@/Util/FormatCentsToDollars';

export default function Show(props) {

    const order = props.order;


    const orderDetails = [
        { name: 'Full name', value: order.name },
        { name: 'Email', value: order.email },
        { name: 'Status', value: order.order_status },
        { name: 'Transaction ID', value: order.transaction_id },
        { name: 'Shipper', value: order.shipper_name },
        { name: 'Tracking Number', value: order.tracking_number },
        { name: 'Total', value: `$${formatCentsToDollars(order.total_cents)}` },
    ];

    const productDetails = [
        { name: 'Product name', value: order.product.name },
        { name: 'Brand', value: order.product.brand },
        { name: 'Color', value: order.inventory.color },
        { name: 'Size', value: order.inventory.size },
        { name: 'Sku', value: order.inventory.sku },
    ];

    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Order #{order.id}</h2>}
        >
            <Head title={`Order #${order.id}`} />

            <div className="py-8">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    <div className="flex flex-col divide-y-2 divide-gray-300 divide-dashed
                     ">
                        <div className="py-5">
                            <div className="bg-white shadow overflow-hidden sm:rounded-lg">
                                <div className="px-4 py-5 sm:px-6">
                                    <h3 className="text-lg leading-6 font-medium text-gray-900">Order Information</h3>
                                    <p className="mt-1 max-w-2xl text-sm text-gray-500">Personal details and Sales.</p>
                                </div>
                                <div className="border-t border-gray-200 px-4 py-5 sm:p-0">
                                    <dl className="sm:divide-y sm:divide-gray-200">
                                        {orderDetails.map((item) => (
                                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt className="text-sm font-medium text-gray-500">{item.name}</dt>
                                                <dd className="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{item.value}</dd>
                                            </div>
                                        ))}
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div className="py-5">
                            <div className="bg-white shadow overflow-hidden sm:rounded-lg">
                                <div className="px-4 py-5 sm:px-6">
                                    <h3 className="text-lg leading-6 font-medium text-gray-900">Product Information</h3>
                                    <p className="mt-1 max-w-2xl text-sm text-gray-500">Product and Inventory Detail </p>
                                </div>
                                <div className="border-t border-gray-200 px-4 py-5 sm:p-0">
                                    <dl className="sm:divide-y sm:divide-gray-200">
                                        {productDetails.map((item) => (
                                            <div className="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt className="text-sm font-medium text-gray-500">{item.name}</dt>
                                                <dd className="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{item.value}</dd>
                                            </div>
                                        ))}
                                    </dl>
                                </div>
                            </div>
                        </div>

                    </div>



                </div>
            </div>
        </Authenticated>
    );
}
