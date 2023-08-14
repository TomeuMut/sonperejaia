module.exports = {    
    content: [
        './pages/*.js',
        './pages/*.vue',
        './pages/*.htm',
        './content/*.htm',
        './partials/**/*.htm',
        './layouts/*.htm',
        './../../plugins/**/*.htm',       
    ],
    theme: {
        extend: {
            transitionDuration: {
                DEFAULT: '300ms',
                '400': '400ms'
            },
            keyframes: {
                appearTop: {
                    '0%': { transform: 'translateY(-100%)' },
                    '100%': { transform: 'translateY(0)' },
                },
                moveUpDown: {
                    '0%': { transform:'translatex(8px)' },
                    '50%': { transform: 'translatex(32px)' },
                    '100%': { transform:'translatex(8px)' }
                }
            },
            animation: {
                movingUp: 'moveUpDown 6s linear infinite',
            },
            colors: {
                primary: '#9e8b46',
                primaryDark: '#9e8b46',
                secondary: '#231f20',
                secondaryLight: '#231f20',
                secondaryDark: '#122138',
                textDark: '#1F2125',
                textDarkBg: '#DDE7F5',
                textLight: '#FFFFFF',
                textHint: '#89909B',
                textGray: '#626A77',
                linkDark: '#A7C9FB',
                linkLight: '#3B69AC',
                linkExtraDark: '#25497E',
                linkExtraLight: '#4881D5',
                transparent: 'transparent',
                current: 'currentColor'
            },
            fill: theme => ({
                'primary': theme('colors.primary'),
                'primaryDark': theme('colors.primaryDark'),
                'secondary': theme('colors.secondary'),
                'secondaryLight': theme('colors.secondaryLight'),
                'secondaryDark': theme('colors.secondaryDark'),
                'textDark': theme('colors.textDark'),
                'textDarkBg': theme('colors.textDarkBg'),
                'textLight': theme('colors.textLight'),
                'textHint': theme('colors.textHint'),
                'textGray': theme('colors.textGray'),
                'linkDark': theme('colors.linkDark'),
                'linkLight': theme('colors.linkLight'),
                'linkExtraLight': theme('colors.linkExtraLight'),
                'linkExtraDark': theme('colors.linkExtraDark'),
                'transparent': theme('colors.transparent'),
                'current': theme('colors.current'),
            }),
            screens: {
                '-3xl': {'max': '1799px'},
                '3xl': {'min': '1800px'},
                '-2xl': {'max': '1535px'},
                '-xl': {'max': '1279px'},
                '-lg': {'max': '1023px'},
                '-md': {'max': '767px'},
                '-sm': {'max': '639px'},
                'md-lg': {'min': '768px', 'max' : '1023px'},
                'md-xl': {'min': '768px', 'max' : '1279px'},
                'md-2xl': {'min': '768px', 'max' : '1535px'},
                'md-3xl': {'min': '768px', 'max' : '1799px'},
                'lowScreen': { 'raw': '(max-height: 850px)' },
                'lowScreenMobile': { 'raw': '(max-width: 767px) and (max-height: 850px)' },
                'tinyScreenMobile': { 'raw': '(max-width: 767px) and (max-height: 700px)' }
            },
            gridTemplateColumns: {
                '6': 'repeat(6, minmax(0, 1fr))',
                '7': 'repeat(7, minmax(0, 1fr))',
                '12': 'repeat(12, minmax(0, 1fr))'
            },
            borderWidth: {
                '3': '3px'
            },
            width: {
                '1/7': '14.2857143%',
                '2/7': '28.5714286%',
                '3/7': '42.8571429%',
                '4/7': '57.1428571%',
                '5/7': '71.4285714%',
                '6/7': '85.7142857%',
                '1/8': '12.5%',
                '2/8': '25%',
                '3/8': '37.5%',
                '4/8': '50%',
                '5/8': '62.5%',
                '6/8': '75%',
                '7/8': '87.5%',
                '1/9': '11.1111111%',
                '2/9': '22.2222222%',
                '3/9': '33.333333%',
                '4/9': '44.4444444%',
                '5/9': '55.5555555%',
                '6/9': '66.6666666%',
                '7/9': '77.7777777%',
                '8/9': '88.8888888%',
                '1/10': '10%',
                '2/10': '20%',
                '3/10': '30%',
                '4/10': '40%',
                '5/10': '50%',
                '6/10': '60%',
                '7/10': '70%',
                '8/10': '80%',
                '9/10': '90%',
                '1/11': '9%',
                '2/11': '18.2%',
                '3/11': '27.27%',
                '4/11': '36.36%',
                '5/11': '45.45%',
                '6/11': '54.54%',
                '7/11': '63.63%',
                '8/11': '72.72%',
                '9/11': '81.81%',
                '10/11': '90.9%'
            },
            gridColumn: {
                'auto-span-2': 'auto / span 2',
            },
            gridRow: {
                'auto-span-2': 'auto / span 2',
            },
            boxShadow: {
                'sombra-80': '0px 0px 80px rgba(0, 0, 0, 0.35)',
                'sombra-48': '0px 0px 48px rgba(0, 0, 0, 0.35)',
                'sombra-32': '0px 0px 32px rgba(0, 0, 0, 0.35)',
                'sombra-24': '0px 0px 24px rgba(0, 0, 0, 0.35)',
                'sombra-16': '0px 0px 16px rgba(0, 0, 0, 0.35)',
                'sombra-8': '0px 0px 8px rgba(0, 0, 0, 0.35)',
            },
            lineHeight: {
                '1': '1em',
                '1.1': '1.1em',
                '1.2': '1.2em',
                '1.3': '1.33em',
                '1.4': '1.4em',
                '1.5': '1.5em',
                '1.6': '1.6em',
                '1.7': '1.7em',
                '1.8': '1.8em',
                '1.9': '1.9em',
                '2': '2em',
            },
            zIndex: {
                '1': '1',
                '2': '2',
                '3': '3',
                '4': '4',
                '5': '5',
            }
        },
        container: {
            center: true,
            padding: '16px',
            screens: {
                '2xl': '1612px'
            },
        },
        fontFamily: {
            'neutra': ['Neutra Text, sans-serif'],
            'Garamond': ["'Cormorant Garamond', sans-serif"],            
        },
        spacing: {
            'auto': 'auto',
            '0': '0px',
            '1': '1px',
            '2': '2px',
            '3': '3px',
            '4': '4px',
            '6': '6px',
            '8': '8px',
            '12': '12px',
            '16': '16px',
            '20': '20px',
            '24': '24px',
            '28': '28px',
            '32': '32px',
            '40': '40px',
            '48': '48px',
            '56': '56px',
            '64': '64px',
            '72': '72px',
            '80': '80px',
            '88': '88px',
            '96': '96px',
            '104': '104px',
            '112': '112px',
            '120': '120px',
            '128': '128px',
            '156': '156px',
            '258': '258px',
            '298': '298px',
        },
        fontSize: {
            '8': '8px',
            '10': '10px',
            '11': '11px',
            '12': '12px',
            '13': '13px',
            '14': '14px',
            '15': '15px',
            '16': '16px',
            '18': '18px',
            '20': '20px',
            '22': '22px',
            '24': '24px',
            '26': '26px',
            '28': '28px',
            '30': '30px',
            '32': '32px',
            '34': '34px',
            '36': '36px',
            '38': '38px',
            '40': '40px',
            '42': '42px',
            '44': '44px',
            '48': '48px',
            '50': '50px',
            '54': '54px',
            '55': '55px',
            '58': '58px',
            '60': '60px',
            '64': '64px',
            '65': '65px',
            '70': '70px',
            '75': '75px',
            '80': '80px',
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/line-clamp'),        
    ]
}
