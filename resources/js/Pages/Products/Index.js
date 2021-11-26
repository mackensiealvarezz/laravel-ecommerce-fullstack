import React from 'react';
import Authenticated from '@/Layouts/Authenticated';
import { Head, Link } from '@inertiajs/inertia-react';
import Pagination from '@/Components/Pagination';
import Button from '@/Components/Button';
import FlashMessage from '@/Components/FlashMessage';

export default function Index(props) {

    const products = props.products;

    const productSkus = (product) => {
        return product.inventories.map(function (item) {
            return item.sku;
        }).join(',');
    }

    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Products</h2>}
        >
            <Head title="Products" />
            <FlashMessage success={props.success} />

            <div className="py-8">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
                    <div className="flex items-center justify-end mt-4">
                        <Link
                            href={route('products.create')}
                            className="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest active:bg-gray-900 transition ease-in-out duration-150"
                        >Create</Link>
                    </div>
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
                                        Style
                                    </th>
                                    <th
                                        scope="col"
                                        className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Brand
                                    </th>
                                    <th
                                        scope="col"
                                        className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Skus
                                    </th>
                                    <th scope="col" className="relative px-6 py-3">
                                        <span className="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {products.data.map((product) => (
                                    <tr key={product.id}>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{product.name}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{product.style}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{product.brand}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{productSkus(product)}</td>
                                        <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                                            <Link href={route('products.edit', product.id)} className="text-indigo-600 hover:text-indigo-900">
                                                Edit
                                            </Link>
                                            <Link href={route('products.destroy', product.id)} method="delete" as="button" className="text-red-600 hover:text-red-900">
                                                Delete
                                            </Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    <Pagination links={products.links} />
                </div>
            </div>
        </Authenticated>
    );
}
