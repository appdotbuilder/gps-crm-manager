import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="GPS Tracking Business Management">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="flex min-h-screen flex-col items-center bg-gradient-to-br from-blue-50 to-indigo-100 p-6 text-gray-900 lg:justify-center lg:p-8">
                <header className="mb-6 w-full max-w-6xl">
                    <nav className="flex items-center justify-between">
                        <div className="flex items-center space-x-2">
                            <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600">
                                <span className="text-xl">🛰️</span>
                            </div>
                            <span className="text-xl font-bold text-gray-900">GPSTrackPro</span>
                        </div>
                        <div className="flex items-center gap-4">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="inline-block rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-blue-700 transition-colors"
                                >
                                    Go to Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route('login')}
                                        className="inline-block rounded-lg border border-gray-300 px-5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="inline-block rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700 transition-colors"
                                    >
                                        Get Started
                                    </Link>
                                </>
                            )}
                        </div>
                    </nav>
                </header>

                <main className="w-full max-w-6xl">
                    {/* Hero Section */}
                    <div className="text-center mb-16">
                        <h1 className="text-5xl font-bold mb-6 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            🛰️ GPS Tracking Business Management System
                        </h1>
                        <p className="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                            Complete solution for managing leads, customers, inventory, invoicing, and support in the GPS tracking industry. 
                            Streamline your operations with our comprehensive business management platform.
                        </p>
                        {!auth.user && (
                            <div className="flex justify-center gap-4">
                                <Link
                                    href={route('register')}
                                    className="inline-block rounded-lg bg-blue-600 px-8 py-4 text-lg font-medium text-white hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl"
                                >
                                    Start Free Trial
                                </Link>
                                <button className="inline-block rounded-lg border border-gray-300 px-8 py-4 text-lg font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                    Watch Demo
                                </button>
                            </div>
                        )}
                    </div>

                    {/* Features Grid */}
                    <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
                        <div className="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div className="text-3xl mb-4">👥</div>
                            <h3 className="text-lg font-semibold mb-2">Lead Management</h3>
                            <p className="text-gray-600 text-sm">Track leads from multiple sources, assign sales reps, and convert prospects to customers efficiently.</p>
                        </div>
                        
                        <div className="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div className="text-3xl mb-4">🏢</div>
                            <h3 className="text-lg font-semibold mb-2">Customer Management</h3>
                            <p className="text-gray-600 text-sm">Manage customer details, contracts, device counts, and service plans in one centralized system.</p>
                        </div>

                        <div className="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div className="text-3xl mb-4">📦</div>
                            <h3 className="text-lg font-semibold mb-2">Inventory Control</h3>
                            <p className="text-gray-600 text-sm">Track GPS devices, SIM cards, and accessories with automated stock alerts and vendor management.</p>
                        </div>

                        <div className="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div className="text-3xl mb-4">💰</div>
                            <h3 className="text-lg font-semibold mb-2">Billing & Invoicing</h3>
                            <p className="text-gray-600 text-sm">Generate invoices, track payments, and manage recurring billing with multiple payment methods.</p>
                        </div>

                        <div className="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div className="text-3xl mb-4">🎫</div>
                            <h3 className="text-lg font-semibold mb-2">Support Tickets</h3>
                            <p className="text-gray-600 text-sm">Manage customer support requests with priority levels and resolution tracking.</p>
                        </div>

                        <div className="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div className="text-3xl mb-4">✅</div>
                            <h3 className="text-lg font-semibold mb-2">Task Management</h3>
                            <p className="text-gray-600 text-sm">Organize team tasks with due dates, priorities, and assignments linked to customers and leads.</p>
                        </div>

                        <div className="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div className="text-3xl mb-4">📱</div>
                            <h3 className="text-lg font-semibold mb-2">SMS & Email Campaigns</h3>
                            <p className="text-gray-600 text-sm">Create targeted campaigns with personalized templates and customer segmentation.</p>
                        </div>

                        <div className="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div className="text-3xl mb-4">📊</div>
                            <h3 className="text-lg font-semibold mb-2">Analytics Dashboard</h3>
                            <p className="text-gray-600 text-sm">Get insights with comprehensive reports on sales, revenue, and business performance.</p>
                        </div>
                    </div>

                    {/* Key Benefits */}
                    <div className="bg-white rounded-2xl p-8 shadow-xl mb-16">
                        <h2 className="text-3xl font-bold text-center mb-8">Why Choose GPSTrackPro?</h2>
                        <div className="grid md:grid-cols-3 gap-8">
                            <div className="text-center">
                                <div className="text-4xl mb-4">⚡</div>
                                <h3 className="text-xl font-semibold mb-2">All-in-One Solution</h3>
                                <p className="text-gray-600">Complete business management system designed specifically for GPS tracking companies.</p>
                            </div>
                            <div className="text-center">
                                <div className="text-4xl mb-4">🔒</div>
                                <h3 className="text-xl font-semibold mb-2">Secure & Reliable</h3>
                                <p className="text-gray-600">Enterprise-grade security with role-based access control and data encryption.</p>
                            </div>
                            <div className="text-center">
                                <div className="text-4xl mb-4">📈</div>
                                <h3 className="text-xl font-semibold mb-2">Scale Your Business</h3>
                                <p className="text-gray-600">Grow from startup to enterprise with our scalable platform and automation tools.</p>
                            </div>
                        </div>
                    </div>

                    {/* CTA Section */}
                    {!auth.user && (
                        <div className="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-8 text-center text-white">
                            <h2 className="text-3xl font-bold mb-4">Ready to Transform Your Business?</h2>
                            <p className="text-xl mb-6 opacity-90">Join hundreds of GPS tracking companies already using our platform</p>
                            <Link
                                href={route('register')}
                                className="inline-block rounded-lg bg-white px-8 py-4 text-lg font-medium text-blue-600 hover:bg-gray-100 transition-colors shadow-lg"
                            >
                                Start Your Free Trial Today
                            </Link>
                        </div>
                    )}

                    {/* Footer */}
                    <footer className="text-center mt-16 text-gray-500">
                        <p>Built with ❤️ for GPS tracking businesses worldwide</p>
                    </footer>
                </main>
            </div>
        </>
    );
}