import React from 'react';
import Authenticated from '@/Layouts/Authenticated';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import Pagination from '@/Components/Pagination';
import Button from '@/Components/Button';
import FlashMessage from '@/Components/FlashMessage';
import Input from '@/Components/Input';

export default function Breakdown(props) {

    const breakdown = props.breakdown;
    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Orders Breakdown</h2>}
        >
            <Head title="Orders Breakdown" />

            <FlashMessage success={props.success} />

            <div className="py-8">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">


                    <div className="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th
                                        scope="col"
                                        className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        State
                                    </th>

                                    <th
                                        scope="col"
                                        className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Open
                                    </th>
                                    <th
                                        scope="col"
                                        className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Pending
                                    </th>
                                    <th
                                        scope="col"
                                        className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Fulfulled
                                    </th>
                                    <th
                                        scope="col"
                                        className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Shipped
                                    </th>
                                    <th
                                        scope="col"
                                        className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Paid
                                    </th>

                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {breakdown.data.map((state, index) => (
                                    <tr key={state.state}>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{state.state}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{state.open}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{state.pending}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{state.fulfulled}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{state.shipped}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{state.paid}</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    <Pagination links={breakdown.links} />
                </div>
            </div>
        </Authenticated>
    );
}
