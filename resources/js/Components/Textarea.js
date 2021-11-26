import React, { useEffect, useRef } from 'react';

export default function Textarea({
    name,
    value,
    className,
    rows = 3,
    required,
    handleChange,
}) {
    const input = useRef();

    return (
        <div className="flex flex-col items-start">
            <textarea
                name={name}
                value={value}
                rows={rows}
                className={
                    `shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md ` +
                    className
                }
                ref={input}
                required={required}
                onChange={(e) => handleChange(e)}
            />
        </div>
    );
}
