<?php require_once 'views/layout/header.php'; ?>

<div style="min-height: 80vh;">
    <div style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.9), rgba(155, 89, 182, 0.9)), url('assets/imagenes/Imagen de WhatsApp 2025-06-20 a las 23.47.39_e7804b75.jpg'); background-size: cover; background-position: center; padding: 4rem 2rem; text-align: center; color: white; border-radius: 20px; margin-bottom: 3rem; position: relative;">
        <div style="background: rgba(0, 0, 0, 0.3); padding: 3rem; border-radius: 15px; backdrop-filter: blur(10px);">
            <h1 style="font-size: 3rem; margin-bottom: 1rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                🏪 Bienvenido a ANCASTI
            </h1>
            <h2 style="font-size: 1.8rem; margin-bottom: 2rem; font-weight: 300; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                Sistema de Control de Ventas
            </h2>
            <p style="font-size: 1.2rem; max-width: 800px; margin: 0 auto; line-height: 1.8; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                Soluciones tecnológicas innovadoras para el crecimiento de tu negocio. 
                Gestiona tus ventas, inventario y clientes de manera eficiente y profesional.
            </p>
        </div>
    </div>

    <!-- Información de la Empresa -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 3rem;">
        <!-- Información Principal -->
        <div class="card hover-lift">
            <h3 style="color: #3498db; margin-bottom: 1.5rem; font-size: 1.5rem;">
                🏢 Sobre ANCASTI
            </h3>
            <div style="line-height: 1.8; color: #2c3e50;">
                <p style="margin-bottom: 1.5rem;">
                    <strong>ANCASTI</strong> es una empresa líder en soluciones tecnológicas, 
                    especializada en el desarrollo de sistemas de gestión empresarial que 
                    impulsan el crecimiento y la eficiencia de los negocios.
                </p>
                
                <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin: 1.5rem 0;">
                    <h4 style="color: #3498db; margin-bottom: 1rem;">🎯 Nuestra Misión</h4>
                    <p style="margin: 0;">
                        Proporcionar herramientas tecnológicas innovadoras que simplifiquen 
                        la gestión empresarial y potencien el éxito de nuestros clientes.
                    </p>
                </div>

                <div style="background: #f0fff4; padding: 1.5rem; border-radius: 10px; border-left: 4px solid #27ae60;">
                    <h4 style="color: #27ae60; margin-bottom: 1rem;">🚀 Nuestra Visión</h4>
                    <p style="margin: 0;">
                        Ser la empresa de referencia en soluciones de gestión empresarial, 
                        reconocida por la calidad, innovación y excelencia en el servicio.
                    </p>
                </div>
            </div>
        </div>

        <!-- Servicios y Contacto -->
        <div class="card hover-lift">
            <h3 style="color: #e74c3c; margin-bottom: 1.5rem; font-size: 1.5rem;">
                📞 Información de Contacto
            </h3>
            
            <div style="space-y: 1.5rem;">
                <div style="display: flex; align-items: center; margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <div style="background: #3498db; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem; font-size: 1.2rem;">
                        📍
                    </div>
                    <div>
                        <strong style="color: #2c3e50;">Dirección:</strong><br>
                        <span style="color: #7f8c8d;">Av. Principal #123, Centro Comercial Plaza Mayor, Local 45<br>
                        Ciudad Empresarial, Estado Miranda, Venezuela</span>
                    </div>
                </div>

                <div style="display: flex; align-items: center; margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <div style="background: #27ae60; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem; font-size: 1.2rem;">
                        📱
                    </div>
                    <div>
                        <strong style="color: #2c3e50;">Teléfonos:</strong><br>
                        <span style="color: #7f8c8d;">+58 212-555-0123<br>
                        +58 414-555-0456</span>
                    </div>
                </div>

                <div style="display: flex; align-items: center; margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <div style="background: #e74c3c; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem; font-size: 1.2rem;">
                        📧
                    </div>
                    <div>
                        <strong style="color: #2c3e50;">Email:</strong><br>
                        <span style="color: #7f8c8d;">info@ancasti.com<br>
                        soporte@ancasti.com</span>
                    </div>
                </div>

                <div style="display: flex; align-items: center; margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <div style="background: #f39c12; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem; font-size: 1.2rem;">
                        🕐
                    </div>
                    <div>
                        <strong style="color: #2c3e50;">Horario de Atención:</strong><br>
                        <span style="color: #7f8c8d;">Lunes a Viernes: 8:00 AM - 6:00 PM<br>
                        Sábados: 9:00 AM - 2:00 PM</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Servicios -->
    <div class="card" style="margin-bottom: 3rem;">
        <h3 style="color: #9b59b6; margin-bottom: 2rem; text-align: center; font-size: 1.8rem;">
            💼 Nuestros Servicios
        </h3>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div style="text-align: center; padding: 2rem; background: linear-gradient(135deg, #3498db, #2980b9); color: white; border-radius: 15px; transition: transform 0.3s ease;" class="hover-lift">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🖥️</div>
                <h4 style="margin-bottom: 1rem;">Sistemas de Gestión</h4>
                <p style="opacity: 0.9; line-height: 1.6;">
                    Desarrollo de sistemas personalizados para la gestión integral de tu negocio.
                </p>
            </div>

            <div style="text-align: center; padding: 2rem; background: linear-gradient(135deg, #27ae60, #229954); color: white; border-radius: 15px; transition: transform 0.3s ease;" class="hover-lift">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📊</div>
                <h4 style="margin-bottom: 1rem;">Control de Inventario</h4>
                <p style="opacity: 0.9; line-height: 1.6;">
                    Soluciones avanzadas para el control y seguimiento de tu inventario.
                </p>
            </div>

            <div style="text-align: center; padding: 2rem; background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; border-radius: 15px; transition: transform 0.3s ease;" class="hover-lift">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📈</div>
                <h4 style="margin-bottom: 1rem;">Reportes y Analytics</h4>
                <p style="opacity: 0.9; line-height: 1.6;">
                    Análisis detallados y reportes inteligentes para la toma de decisiones.
                </p>
            </div>

            <div style="text-align: center; padding: 2rem; background: linear-gradient(135deg, #f39c12, #e67e22); color: white; border-radius: 15px; transition: transform 0.3s ease;" class="hover-lift">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🛡️</div>
                <h4 style="margin-bottom: 1rem;">Soporte Técnico</h4>
                <p style="opacity: 0.9; line-height: 1.6;">
                    Asistencia técnica especializada y mantenimiento continuo.
                </p>
            </div>
        </div>
    </div>

    <div style="text-align: center; padding: 3rem; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 20px; margin-bottom: 2rem;">
        <h3 style="font-size: 2rem; margin-bottom: 1rem;">
            🚀 ¡Comienza a Gestionar tu Negocio Hoy!
        </h3>
        <p style="font-size: 1.1rem; margin-bottom: 2rem; opacity: 0.9;">
            Accede al panel de control para comenzar a utilizar todas las funcionalidades del sistema.
        </p>
        <a href="index.php?action=panel" class="btn" style="background: white; color: #667eea; font-size: 1.1rem; padding: 1rem 2rem; text-decoration: none; border-radius: 50px; font-weight: 600; transition: all 0.3s ease;">
            📊 Ir al Panel de Control
        </a>
    </div>
</div>

<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
    
    h1[style*="font-size: 3rem"] {
        font-size: 2rem !important;
    }
    
    h2[style*="font-size: 1.8rem"] {
        font-size: 1.4rem !important;
    }
    
    div[style*="padding: 4rem 2rem"] {
        padding: 2rem 1rem !important;
    }
    
    div[style*="padding: 3rem"] {
        padding: 2rem !important;
    }
}
</style>

<?php require_once 'views/layout/footer.php'; ?>