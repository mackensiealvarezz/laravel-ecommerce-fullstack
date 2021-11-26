import { Link } from "@inertiajs/inertia-react";

export default function Pagination({ links }) {
    return (
        <div className="mt-6">
            <div className="flex flex-wrap -mb-1">
                {links.map((link, idx) => (
                    !link.url ? (
                        <div key={idx} className="mr-1 mb-1 px-4 py-3 text-sm leading-4 bg-white text-gray-400 border rounded">{
                            link.label}
                        </div>
                    )
                        : (
                            <Link key={idx} href={link.url} className={`mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded ${link.active ? 'bg-indigo-300 hover:bg-indigo-200' : 'bg-white hover:bg-gray-300'}`}>
                                {link.label}
                            </Link>
                        )
                ))}
            </div>
        </div>
    );
}
