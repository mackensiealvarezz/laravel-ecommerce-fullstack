import React from 'react';
import Authenticated from '@/Layouts/Authenticated';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import Pagination from '@/Components/Pagination';
import Button from '@/Components/Button';
import FlashMessage from '@/Components/FlashMessage';
import Input from '@/Components/Input';
import formatCentsToDollars from '@/Util/FormatCentsToDollars';

export default function Index(props) {

    const { data, setData, get, processing, errors, reset } = useForm({
        search: props.filters.search
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const orders = props.orders;

    const stats = [
        { name: 'Total Orders', stat: orders.total },
        { name: 'Total Sale', stat: `$ ${formatCentsToDollars(props.stats.total_sales_sum)}` },
        { name: 'Avg. Sale', stat: `$ ${formatCentsToDollars(props.stats.avg_sales_sum)}` },
    ]

    const submit = (e) => {
        e.preventDefault();
        get(route(route().current()));
    };


    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Orders</h2>}
        >
            <Head title="Orders" />

            <FlashMessage success={props.success} />

            <div className="py-8">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
                    <div className="flex flex-col w-full mt-4">
                        <div className="flex justify-between">
                            <h3 className="text-lg leading-6 font-medium text-gray-900">Stats</h3>
                            <Link
                                href={route('orders.breakdown')}
                                className="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest active:bg-gray-900 transition ease-in-out duration-150"
                            >View Breakdown</Link>
                        </div>
                        <dl className="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                            {stats.map((item) => (
                                <div key={item.name} className="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                    <dt className="text-sm font-medium text-gray-500 truncate">{item.name}</dt>
                                    <dd className="mt-1 text-3xl font-semibold text-gray-900">{item.stat}</dd>
                                </div>
                            ))}
                        </dl>
                    </div>

                    <form className="flex space-x-2" onSubmit={submit}>
                        <Input
                            type="text"
                            name="search"
                            value={data.search || ''}
                            handleChange={onHandleChange}
                            placeholder="Search By Product or sku"
                        />
                        <Button processing={processing}>Search</Button>
                        <button className="text-indigo-400 font-medium" onClick={reset}>Reset</button>
                    </form>

                    <div className="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th
                                        scope="col"
                                        className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Name
                                    </th>
                                    <th
                                        scope="col"
                                        className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Email
                                    </th>
                                    <th
                                        scope="col"
                                        className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Product(Sku)
                                    </th>
                                    <th
                                        scope="col"
                                        className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Status
                                    </th>
                                    <th
                                        scope="col"
                                        className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Total
                                    </th>
                                    <th scope="col" className="relative px-6 py-3">
                                        <span className="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {orders.data.map((order) => (
                                    <tr key={order.id}>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{order.name}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{order.email}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{`${order.product.name}(${order.inventory.sku})`}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{order.order_status}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{`$${formatCentsToDollars(order.total_cents)}`}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                                            <Link href={route('orders.show', order.id)} className="text-indigo-600 hover:text-indigo-900">
                                                View
                                            </Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    <Pagination links={orders.links} />
                </div>
            </div>
        </Authenticated>
    );
}
