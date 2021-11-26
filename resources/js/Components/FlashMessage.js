import React from 'react';

export default function FlashMessage({ success }) {
    return (
        success && (
            <div className="bg-green-300 text-green-900 py-4 px-4">
                <div className="font-medium">{success}</div>
            </div>
        )
    );
}
