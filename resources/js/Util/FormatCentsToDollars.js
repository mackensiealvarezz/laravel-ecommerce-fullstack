export default function formatCentsToDollars(cents) {
    return new Intl.NumberFormat({ style: 'currency', currency: 'USD', maximumFractionDigits: 2 }).format(cents / 100);
}
