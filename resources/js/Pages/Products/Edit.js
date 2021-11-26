import React from 'react';
import Authenticated from '@/Layouts/Authenticated';
import { Head, Link, useForm } from '@inertiajs/inertia-react';
import Label from '@/Components/Label';
import Input from '@/Components/Input';
import Textarea from '@/Components/Textarea';
import ValidationErrors from '@/Components/ValidationErrors';
import Button from '@/Components/Button';
import FlashMessage from '@/Components/FlashMessage';

export default function Edit(props) {
    const product = props.product;

    const { data, setData, put, processing, errors, reset } = useForm({
        name: product.name,
        description: product.description,
        style: product.style,
        brand: product.brand,
        type: product.type,
        url: product.url ?? '',
        shipping_price: product.shipping_price,
        note: product.note ?? '',
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };


    const submit = (e) => {
        e.preventDefault();
        put(route('products.update', product.id));
    };

    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Edit {product.name}</h2>}
        >
            <Head title={`Edit ${product.name} `} />

            <ValidationErrors errors={errors} />
            <FlashMessage success={props.success} />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="px-6 py-4 bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <form onSubmit={submit}>
                            <div className="space-y-6">
                                <div>
                                    <h3 className="text-lg leading-6 font-medium text-gray-900">Product Information</h3>
                                    <p className="mt-1 text-sm text-gray-500">Use this form to edit the product information</p>
                                </div>

                                <div>
                                    <Label forInput="name" value="Name" />
                                    <Input
                                        type="text"
                                        name="name"
                                        value={data.name}
                                        className="mt-1 block w-full"
                                        isFocused={true}
                                        handleChange={onHandleChange}
                                    />
                                </div>

                                <div>
                                    <Label forInput="description" value="Description" />
                                    <Textarea
                                        name="description"
                                        value={data.description}
                                        className="mt-1 block w-full"
                                        handleChange={onHandleChange}
                                    />
                                </div>

                                <div>
                                    <Label forInput="style" value="Style" />
                                    <Input
                                        type="text"
                                        name="style"
                                        value={data.style}
                                        className="mt-1 block w-full"
                                        handleChange={onHandleChange}
                                    />
                                </div>

                                <div>
                                    <Label forInput="brand" value="Brand" />
                                    <Input
                                        type="text"
                                        name="brand"
                                        value={data.brand}
                                        className="mt-1 block w-full"
                                        handleChange={onHandleChange}
                                    />
                                </div>

                                <div>
                                    <Label forInput="type" value="Type" />
                                    <Input
                                        type="text"
                                        name="type"
                                        value={data.type}
                                        className="mt-1 block w-full"
                                        handleChange={onHandleChange}
                                    />
                                </div>

                                <div>
                                    <Label forInput="shipping_price" value="Shipping Price" />
                                    <Input
                                        type="number"
                                        name="shipping_price"
                                        value={data.shipping_price}
                                        className="mt-1 block w-full"
                                        handleChange={onHandleChange}
                                    />
                                </div>

                                <div>
                                    <Label forInput="url" value="Url" />
                                    <Input
                                        type="url"
                                        name="url"
                                        value={data.url}
                                        className="mt-1 block w-full"
                                        handleChange={onHandleChange}
                                    />
                                </div>

                                <div>
                                    <Label forInput="note" value="Note" />
                                    <Textarea
                                        name="note"
                                        value={data.note}
                                        className="mt-1 block w-full"
                                        handleChange={onHandleChange}
                                    />
                                </div>
                            </div>

                            <div className="flex items-center justify-end mt-4">
                                <Button className="ml-4" processing={processing}>
                                    Update
                                </Button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </Authenticated>
    );
}
