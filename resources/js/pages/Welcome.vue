 · VUE
Copiar

<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
 
defineProps<{ auth: { user: any } }>();
</script>
 
<template>
    <Head title="ClientTrack — Seguimiento de Clientes B2B">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet" />
    </Head>
 
    <div class="root-wrap">
 
        <!-- Fondo decorativo -->
        <div class="bg-grid" aria-hidden="true">
            <div class="grid-dot"></div>
        </div>
        <div class="accent-blob" aria-hidden="true"></div>
 
        <!-- Nav -->
        <header class="nav-bar">
            <div class="brand">
                <span class="brand-icon">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                        <rect x="1" y="1" width="9" height="9" rx="2" fill="currentColor" opacity=".9"/>
                        <rect x="12" y="1" width="9" height="9" rx="2" fill="currentColor" opacity=".4"/>
                        <rect x="1" y="12" width="9" height="9" rx="2" fill="currentColor" opacity=".4"/>
                        <rect x="12" y="12" width="9" height="9" rx="2" fill="currentColor" opacity=".9"/>
                    </svg>
                </span>
                <span class="brand-name">ClientTrack - Superorganics</span>
            </div>
            <nav class="nav-links">
                <template v-if="$page.props.auth?.user">
                    <Link :href="route('dashboard')" class="btn btn-primary">Panel →</Link>
                </template>
                <template v-else>
                    <Link :href="route('login')" class="btn btn-ghost">Iniciar sesión</Link>
                    <Link :href="route('register')" class="btn btn-primary">Comenzar gratis</Link>
                </template>
            </nav>
        </header>
 
        <!-- Hero -->
        <main class="hero">
            <div class="hero-label">Plataforma B2B · Gestión de clientes</div>
 
            <h1 class="hero-title">
                Cada cliente,<br/>
                <em>perfectamente</em> al día
            </h1>
 
            <p class="hero-sub">
                Centraliza el seguimiento, historial e interacciones de todos tus clientes en un solo lugar. 
                Sin hojas de cálculo, sin información perdida.
            </p>
 
            <div class="hero-actions">
                <Link :href="route('register')" class="btn btn-cta">
                    Empezar ahora — es gratis
                </Link>
                <a href="#features" class="btn btn-ghost">Ver cómo funciona ↓</a>
            </div>
 
            <!-- Mini stats -->
            <div class="stats-row">
                <div class="stat">
                    <span class="stat-num">+2.400</span>
                    <span class="stat-label">empresas activas</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat">
                    <span class="stat-num">98%</span>
                    <span class="stat-label">satisfacción</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat">
                    <span class="stat-num">3×</span>
                    <span class="stat-label">más seguimientos</span>
                </div>
            </div>
        </main>
 
        <!-- Features -->
        <section id="features" class="features">
            <div class="feature-card">
                <div class="feat-icon" style="background:#EEF2FF; color:#4F46E5;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>Clientes centralizados</h3>
                <p>Toda la información de contacto, etiquetas y estado en una ficha unificada.</p>
            </div>
            <div class="feature-card">
                <div class="feat-icon" style="background:#F0FDF4; color:#16A34A;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
                <h3>Historial de actividad</h3>
                <p>Registra llamadas, reuniones y correos con fecha y responsable automáticamente.</p>
            </div>
            <div class="feature-card">
                <div class="feat-icon" style="background:#FFF7ED; color:#EA580C;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                </div>
                <h3>Métricas y alertas</h3>
                <p>Detecta clientes inactivos y recibe recordatorios antes de perder oportunidades.</p>
            </div>
            <div class="feature-card">
                <div class="feat-icon" style="background:#FDF4FF; color:#9333EA;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                </div>
                <h3>Equipos y roles</h3>
                <p>Asigna clientes a tu equipo comercial y controla quién ve qué información.</p>
            </div>
        </section>
 
        <!-- CTA final -->
        <section class="bottom-cta">
            <p class="cta-eyebrow">Sin tarjeta de crédito</p>
            <h2 class="cta-title">¿Listo para ordenar tu cartera?</h2>
            <Link :href="route('register')" class="btn btn-cta">Crear cuenta gratuita →</Link>
        </section>
 
        <footer class="site-footer">
            <span>© 2025 ClientTrack</span>
            <span>·</span>
            <a href="#">Privacidad</a>
            <span>·</span>
            <a href="#">Contacto</a>
        </footer>
    </div>
</template>
 
<style scoped>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
 
.root-wrap {
    font-family: 'DM Sans', sans-serif;
    background: #FAFAF9;
    color: #1A1A1A;
    min-height: 100vh;
    position: relative;
    overflow-x: hidden;
}
 
/* ---- Background decorative ---- */
.bg-grid {
    position: fixed;
    inset: 0;
    background-image:
        linear-gradient(rgba(0,0,0,.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0,0,0,.04) 1px, transparent 1px);
    background-size: 48px 48px;
    pointer-events: none;
    z-index: 0;
}
.accent-blob {
    position: fixed;
    top: -120px;
    right: -120px;
    width: 500px;
    height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, #DDD6FE 0%, transparent 70%);
    opacity: .5;
    pointer-events: none;
    z-index: 0;
}
 
/* ---- Nav ---- */
.nav-bar {
    position: relative;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 40px;
    max-width: 1100px;
    margin: 0 auto;
}
.brand {
    display: flex;
    align-items: center;
    gap: 10px;
}
.brand-icon { color: #4F46E5; display: flex; }
.brand-name {
    font-family: 'DM Serif Display', serif;
    font-size: 1.15rem;
    letter-spacing: -.01em;
    color: #111;
}
.nav-links { display: flex; gap: 10px; align-items: center; }
 
/* ---- Buttons ---- */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    border-radius: 8px;
    font-size: .875rem;
    font-weight: 500;
    padding: 9px 20px;
    transition: all .18s ease;
    cursor: pointer;
    border: none;
}
.btn-ghost {
    color: #555;
    background: transparent;
}
.btn-ghost:hover { background: #F0F0EE; color: #111; }
 
.btn-primary {
    background: #111;
    color: #fff;
}
.btn-primary:hover { background: #333; }
 
.btn-cta {
    background: #4F46E5;
    color: #fff;
    padding: 12px 28px;
    font-size: .95rem;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(79,70,229,.3);
}
.btn-cta:hover {
    background: #4338CA;
    transform: translateY(-1px);
    box-shadow: 0 6px 24px rgba(79,70,229,.4);
}
 
/* ---- Hero ---- */
.hero {
    position: relative;
    z-index: 1;
    max-width: 680px;
    margin: 0 auto;
    padding: 80px 40px 60px;
    text-align: center;
}
.hero-label {
    display: inline-block;
    font-size: .75rem;
    font-weight: 500;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: #4F46E5;
    background: #EEF2FF;
    border-radius: 20px;
    padding: 4px 14px;
    margin-bottom: 28px;
}
.hero-title {
    font-family: 'DM Serif Display', serif;
    font-size: clamp(2.4rem, 6vw, 3.8rem);
    line-height: 1.1;
    letter-spacing: -.02em;
    color: #111;
    margin-bottom: 22px;
}
.hero-title em {
    font-style: italic;
    color: #4F46E5;
}
.hero-sub {
    font-size: 1.05rem;
    color: #555;
    line-height: 1.7;
    max-width: 520px;
    margin: 0 auto 36px;
    font-weight: 300;
}
.hero-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 52px;
}
 
/* ---- Stats ---- */
.stats-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 28px;
    padding: 20px 28px;
    background: #fff;
    border-radius: 14px;
    border: 1px solid #E8E8E5;
    box-shadow: 0 2px 12px rgba(0,0,0,.05);
    display: inline-flex;
}
.stat { display: flex; flex-direction: column; align-items: center; gap: 2px; }
.stat-num {
    font-family: 'DM Serif Display', serif;
    font-size: 1.4rem;
    color: #111;
}
.stat-label { font-size: .72rem; color: #888; font-weight: 400; }
.stat-divider { width: 1px; height: 32px; background: #E8E8E5; }
 
/* ---- Features ---- */
.features {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px 40px 80px;
}
.feature-card {
    background: #fff;
    border: 1px solid #E8E8E5;
    border-radius: 14px;
    padding: 28px 24px;
    transition: box-shadow .2s, transform .2s;
}
.feature-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,.08);
    transform: translateY(-2px);
}
.feat-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
}
.feature-card h3 {
    font-family: 'DM Serif Display', serif;
    font-size: 1.05rem;
    color: #111;
    margin-bottom: 8px;
}
.feature-card p {
    font-size: .875rem;
    color: #666;
    line-height: 1.6;
    font-weight: 300;
}
 
/* ---- Bottom CTA ---- */
.bottom-cta {
    position: relative;
    z-index: 1;
    text-align: center;
    padding: 60px 40px 80px;
    background: linear-gradient(180deg, transparent 0%, #EEF2FF 100%);
}
.cta-eyebrow {
    font-size: .75rem;
    font-weight: 500;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: #4F46E5;
    margin-bottom: 12px;
}
.cta-title {
    font-family: 'DM Serif Display', serif;
    font-size: clamp(1.6rem, 4vw, 2.4rem);
    color: #111;
    margin-bottom: 28px;
}
 
/* ---- Footer ---- */
.site-footer {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 20px 40px;
    font-size: .8rem;
    color: #999;
    border-top: 1px solid #E8E8E5;
    background: #fff;
}
.site-footer a { color: #999; text-decoration: none; }
.site-footer a:hover { color: #4F46E5; }
 
@media (max-width: 600px) {
    .nav-bar { padding: 16px 20px; }
    .hero { padding: 60px 20px 40px; }
    .features { padding: 0 20px 60px; grid-template-columns: 1fr; }
    .stats-row { flex-direction: column; gap: 16px; }
    .stat-divider { width: 40px; height: 1px; }
}
</style>